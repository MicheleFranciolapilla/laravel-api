<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;

    protected   $table      =   'Technologies';
    protected   $fillable   =   [
                                    'name',
                                    'slug'
                                ]; 
    // Il seguente metodo, che ha un corrispettivo nel modello della tabella relazionata, (in questo caso "Model Project per tabella Projects") esprime la relazione esistente.
    // Nominiamo il metodo al plurale per esprimere la relazione many-to-many, nel senso che un progetto può essere stato sviluppato con più tecnologie, ed UNA STESSA TECNOLOGIA PUO' ESSERE STATA USATA PER SVILUPPARE PIU' PROGETTI, quindi, sia Projects che Technologies sono tabelle "many". La tabella pivot che gestisce la relazione tra le tabelle Projects e Technologies è la tabella Project_Technology.
    // Il metodo restituisce tutti i progetti di riferimento mediante "belongsToMany".
    public  function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
