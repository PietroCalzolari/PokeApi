<?php

namespace App\Jobs;

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
            Log::info($this->pokemonName . ' imported successfully');
        } else {
            Log::error('Bad call to ' . $this->pokemonUrl . ' : '. $response->status());
        }
    }


}
