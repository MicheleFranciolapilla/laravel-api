<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) 
        {
            // Non stiamo creando una nuova tabella bensì aggiungendo una colonna ad una tabella pre-esistente, quindi, "Schema" chiamerà il metodo statico "table" e non il "create". Inoltre valgono le considerazioni a seguire......
            // La colonna che generiamo avrà il nome "category_id" e sarà di tipo "unsignedBigInteger"; facciamo in modo che possa anche essere "null" per la considerazione che verrà fatta al comando seguente e decidiamo di posizionarla dopo la colonna 'id'
            $table->unsignedBigInteger('category_id')->nullable()->after('id');
            // Dopo aver definito le caratteristiche della colonna ci resta da stabilire la relazione con l'altra tabella e lo facciamo nel seguente modo:
            // Nella nostra tabella, la colonna "category_id" conterrà le foreign keys (metodo foreign) riferite (metodo references) alla primary key deniminata "id" della tabella (metodo on) "Categories". Resta da stabilire il comportamento del database dopo l'eventuale cancellazione del record dalla tabella "Categories", per cui usiamo il　metodo "onDelete" in cui stabiliamo che, in questo caso, in tale evenienza, le foreign keys riferite alle primary keys cancellate, diverranno null (parametro nullable). Per onDelete esistono anche altri parametri, ad esempio il parametro "cascade" il quale implicherebbe una cancellazione a cascata dei record la cui foreign key sia associata alla primary key cancellata.
            $table->foreign('category_id')->references('id')->on('Categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            // Nella funzione "down" dobbiamo stabilire il comportamento del database nel caso di cancellazione della colonna appena aggiunta, ad esempio mediante un migrate:rollback. Dobbiamo quindi, in tal caso, prima di tutto, rimuovere il vincolo di relazione, dopodichè, cancellare la colonna.
            // Con il seguente comando rimuoviamo la relazione esistente tra la tabella "projects" e la tabella per la quale la colonna "category_id" (di projects) rappresenta la foreign key
            $table->dropForeign('projects_category_id_foreign');
            // Solo dopo la rimozione della relazione, si può procedere con la cancellazione della colonna
            $table->dropColumn('category_id');
        });
    }
};
