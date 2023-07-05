<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Project as Project;
use App\Models\Admin\Technology as Technology;

class Project_TechnologyTableSeeder extends Seeder
{
    // Popolamento randomico della tabella pivot
    public function run()
    {
        // Acquisizione di tutti i progetti in tabella
        $all_projects = Project::all();
        // Acquisizione di tutte le tecnologie in tabella
        $all_technologies = Technology::all();
        // Numero totale di tecnologie disponibili
        $technologies = count($all_technologies);
        // Nell'array $technologies_ids_array vengono salvati gli id di ciascuna tecnologia (QUESTA SOLUZIONE TORNA UTILE NEL CASO GENERALE LADDOVE GLI "ID" DELLE VARIE TECNOLOGIE NON SIANO NECESSARIAMENTE IN ORDINE NATURALE, A PARTIRE DA 1)
        $technologies_ids_array = [];
        for ($i = 0; $i < $technologies; $i++)
        {
            $technologies_ids_array[] = $all_technologies[$i]->id;
        }
        // Si ciclano tutti i progetti in tabella
        foreach ($all_projects as $project)
        {
            // Si determina randomicamente, per il progetto del momento, l'ammontare ($n) delle tecnologie utilizzate, da 1 fino al numero massimo disponibile (OGNI PROGETTO DEVE AVERE ALMENO UNA TECNOLOGIA)
            $n = mt_rand(1, $technologies);
            // L'array $technologies_array, azzerato ad ogni ciclo (per ogni progetto) verrà popolato con gli indici delle n tecnologie utilizzate
            $technologies_array = [];
            // Nel seguente ciclo si individuano le n tecnologie da collegare al progetto.
            $counter = 0;
            while ($counter < $n)
            {
                // Nel "do-while" a seguire si continua a determinare randomicamente un indice da utilizzare per estrarre l'id della tecnologia dall'array contenente tutti gli id delle varie tecnologie
                do 
                {
                    $technology_index = mt_rand(0, $technologies - 1);
                } 
                while (in_array($technologies_ids_array[$technology_index], $technologies_array));
                // Il ciclo ha termine quando la tecnologia individuata non sia già presente nell'array di destinazione
                // A questo punto si salva l'id estratto
                $technologies_array[] = $technologies_ids_array[$technology_index];
                $counter++;
            }
            // Una volta individuati tutti gli "id" delle "n" tecnologie del progetto del momento, li si carica nella tabella pivot
            $project->technologies()->attach($technologies_array);
        }
    }
}
