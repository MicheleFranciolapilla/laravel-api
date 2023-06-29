<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected   $table      =   'Categories';

    protected   $fillable   =   [
                                    'name',
                                    'slug'
                                ];

    // Il seguente metodo, che ha un corrispettivo nel modello della tabella relazionata, (in questo caso "Model Project per tabella Projects") esprime la relazione esistente.
    // Nominiamo il metodo al plurale per esprimere la relazione one-to-many, nel senso che un progetto può essere riferito ad una sola categoria, mentre UNA CATEGORIA PUO' ESSERE DI RIFERIMENTO PER PIU' PROGETTI, quindi, in quest'ottica, Categories è la tabella "one".
    // Il metodo restituisce tutti i progetti di riferimento mediante "hasMany".
    public  function projects()
    {
        return $this->hasMany(Project::class);
    }
}
