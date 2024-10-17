<?php

namespace App\Jobs;

use App\Models\Move;
use App\Models\Pokemon;
use App\Models\Statistic;
use App\Models\Type;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PokemonImport implements ShouldQueue
{
    use Queueable;

    protected $pokemonName;
    protected $pokemonUrl;

    /**
     * Construct
     */
    public function __construct($pokemonName, $pokemonUrl)
    {
        $this->pokemonName = $pokemonName;
        $this->pokemonUrl = $pokemonUrl;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::get($this->pokemonUrl);
        if ($response->successful()) {
            $data = $response->json();

            //POKEMON
            $pokemon = Pokemon::updateOrCreate(
                [
                    'pokeid' => $data['id'],
                ],
                [
                    'pokeid' => $data['id'],
                    'name' => $data['name'],
                    'base_experience' => $data['base_experience'],
                    'height' => $data['height'],
                    'weight' => $data['weight']
                ]
            );
            $pokemon->save();

            //TYPES
            foreach ($data['types'] as $type) {
                $typeUrl = $type['type']['url'];
                $typePokeId = explode('/', $typeUrl)[6];
                $pokemonType = Type::updateOrCreate(
                    [
                        'pokeid' => $typePokeId
                    ],
                    [
                        'pokeid' => $typePokeId,
                        'name' => $type['type']['name']
                    ]
                );
                $pokemonType->save();
                if (!$pokemon->types->contains($pokemonType))
                    $pokemon->types()->attach($pokemonType, ['created_at' => now(), 'updated_at' => now()]);
            }

            //MOVES
            foreach ($data['moves'] as $move) {
                $moveUrl = $move['move']['url'];
                $response = Http::get($moveUrl);
                if ($response->successful()) {
                    $dataMove = $response->json();

                    //Take the english effect
                    $effectEntries = $dataMove['effect_entries'];
                    foreach ($effectEntries as $effect) {
                        if ($effect['language']['name'] === 'en') {
                            $effectMove = $effect['effect'];
                            break;
                        }
                    }
                    $pokemonMove = Move::updateOrCreate(
                        [
                            'pokeid' => $dataMove['id']
                        ],
                        [
                            'pokeid' => $dataMove['id'],
                            'name' => $dataMove['name'],
                            'effect' => $effectMove,
                            'pp' => $dataMove['pp'],
                            'type' => $dataMove['type']['name'],
                            'accuracy' => $dataMove['accuracy'],
                            'power' => $dataMove['power']
                        ]
                    );
                    $pokemonMove->save();
                    if (!$pokemon->moves->contains($pokemonMove))
                        $pokemon->moves()->attach($pokemonMove, ['created_at' => now(), 'updated_at' => now()]);
                } else {
                    Log::error('Bad call to '. $moveUrl.' : '. $response->status());
                }
            }

            //STATISTICS
            foreach ($data['stats'] as $stat) {
                $statUrl = $stat['stat']['url'];
                $statPokeId = explode('/', $statUrl)[6];
                $pokemonStat = Statistic::updateOrCreate(
                    [
                        'pokeid' => $statPokeId
                    ],
                    [
                        'pokeid' => $statPokeId,
                        'name' => $stat['stat']['name']
                    ]
                );
                $pokemonStat->save();
                if (!$pokemon->statistics->contains($pokemonStat))
                    $pokemon->statistics()->attach($pokemonStat, ['value' => $stat['base_stat'], 'created_at' => now(), 'updated_at' => now()]);
            }

            Log::info($this->pokemonName . ' imported successfully');
        } else {
            Log::error('Bad call to ' . $this->pokemonUrl . ' : ' . $response->status());
        }
    }
}
