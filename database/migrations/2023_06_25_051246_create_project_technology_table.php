<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration della tabella pivot della relazione molti-a-molti, tra le tabelle Projects e Technologies
// La nomenclatura standard delle tabelle pivot è del tipo tab1_tab2, dove tab1 e tab2 sono i nomi in inglese ed al singolare delle rispettive tabelle e tab1 viene prima di tab2 in ordine alfabetico
return new class extends Migration
{
    public function up()
    {
        Schema::create('project_technology', function (Blueprint $table) 
        // Convenzionalmente, nelle tabelle pivot non includiamo le colonne id e timestamp
        {
            // Una volta assegnate le caratteristiche delle colonne: nome e tipo di dato, si procede con l'implementazione delle relazioni...
            // Leggiamo le relazioni nel seguente modo:
            // Nella tabella pivot, la colonna denominata "project_id" (o "technology_id") contiene la foreign key (metodo foreign) corrispondente alla colonna (metodo references) "id" della rispettiva tabella "projects" (o "technologies") (metodo on); alla cancellazione del record cui fa riferimento la foreign key, all'interno della tabella "Projects" (o "Technologies"), i corrispondenti records nella tabella pivot verranno cancellati (metodo cascadeOnDelete)
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete();
            $table->unsignedBigInteger('technology_id');
            $table->foreign('technology_id')->references('id')->on('technologies')->cascadeOnDelete();
            // La seguente istruzione, NON INDISPENSABILE, almeno in questo caso, conferisce lo status di primary key della tabella pivot (avendo scelto di rimuovere la canonica colonna "id"); in questo caso la primary key è duplice
            $table->primary(['project_id', 'technology_id']);
        });
    }

    public function down()
    {
        // A differenza della migration con aggiunta di colonna relazionale, nella one-to-many, in questo caso, la funzione down resta canonica, ossia, se si cancella la tabella si perde l'intera relazione (che è esplicitata proprio nella tabella in sè)
        Schema::dropIfExists('project_technology');
    }
};
