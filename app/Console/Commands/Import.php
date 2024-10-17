<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\PokemonImport;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command imports all the pokemon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiUrl = 'https://pokeapi.co/api/v2/pokemon';
        $response = Http::get($apiUrl);
        if ($response->successful()) {
            $data = $response->json();
            if (array_key_exists('results', $data)) {
                foreach ($data['results'] as $pokemon) {
                    dispatch(new PokemonImport($pokemon['name'], $pokemon['url']));
                }
            }
        }
        else {
            Log::error('Bad call to ' . $apiUrl . ' : ' . $response->status());
            return 1;
        }
    }
}
