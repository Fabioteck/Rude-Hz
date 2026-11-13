<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Manual;
use Illuminate\Support\Str;

class ManualsSeeder extends Seeder
{
    public function run(): void
    {
        $manuals = [
            [
                'title' => 'Sintesi subtractiva: concetti base',
                'category' => 'Sintesi',
                'level' => 'Base',
                'summary' => 'Introduzione fondamentale agli oscillatori, filtri passa-basso e inviluppi ADSR nella produzione techno.',
                'content' => 'La sintesi sottrattiva è il pilastro della musica elettronica underground. Partendo da forme d’onda ricche di armoniche (dente di sega, quadro), il filtro modella lo spettro frequenziale rimuovendo le alte frequenze. L’inviluppo ADSR (Attack, Decay, Sustain, Release) controlla l’apertura del filtro nel tempo, conferendo dinamica e mordente a synth bass e lead.',
            ],
            [
                'title' => 'Campionatori: slicing e resampling',
                'category' => 'Campionamento',
                'level' => 'Intermedio',
                'summary' => 'Tecniche avanzate di chop, slicing e resampling analogico per creare ritmiche industriali e texture uniche.',
                'content' => 'Il campionatore non è solo un lettore di file audio, ma uno strumento scultoreo. Attraverso lo slicing dei transienti e il resampling a bit rate ridotti si ottiene quel carattere grezzo e industriale tipico del sound Rude-Hz. Sperimenta l’inversione dei loop e la modulazione dei punti di start/end.',
            ],
            [
                'title' => 'Drum machine: groove e layering',
                'category' => 'Ritmica',
                'level' => 'Avanzato',
                'summary' => 'Costruzione di drum kit potenti, tecniche di layering per kick massicci e gestione del groove non quantizzato.',
                'content' => 'Un groove solido nasce dalla cura millimetrica dei transienti e della dinamica. Il layering di un kick elettronico con un layer acustico o filtrato garantisce presenza sia sulle basse frequenze (sub) che sulle medie (click). Evita la quantizzazione rigida per preservare il respiro umano e l’inerzia analogica.',
            ],
        ];

        foreach ($manuals as $data) {
            Manual::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                array_merge($data, ['is_published' => true])
            );
        }
    }
}
