<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected   $table      =   'Projects';

    protected   $fillable   =   [
                                    'category_id',
                                    'title',
                                    'slug',
                                    'description',
                                    'host_url',
                                    'cover_img'
                                ];

    public  static  function title_slug(string $_title) : string
    {
        return Str::slug($_title, '-');
    }

    // Il seguente metodo, che ha un corrispettivo nel modello della tabella relazionata, (in questo caso "Model Category per tabella Categories") esprime la relazione esistente.
    // Nominiamo il metodo al singolare per esprimere la relazione one-to-many, nel senso che UN PROGETTO PUO' ESSERE RIFERITO AD UNA SOLA CATEGORIA, mentre una categoria può essere di riferimento a più progetti, quindi, in quest'ottica, Projects è la tabella "many".
    // Il metodo restituisce la categoria di riferimento mediante "belongsTo".
    public  function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Il seguente metodo, che ha un corrispettivo nel modello della tabella relazionata, (in questo caso "Model Technology per tabella Technologies") esprime la relazione esistente.
    // Nominiamo il metodo al plurale per esprimere la relazione many-to-many, nel senso che UN PROGETTO PUO' ESSERE STATO SVILUPPATO CON PIU' TECNOLOGIE, ed una stessa tecnologia può essere stata usata per sviluppare più progetti, quindi, sia Projects che Technologies sono tabelle "many". La tabella pivot che gestisce la relazione tra le tabelle Projects e Technologies è la tabella Project_Technology.
    // Il metodo restituisce tutte le tecnologie di riferimento mediante "belongsToMany".
    public  function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    public  function get_category_string() : string
    {
        if (!isset($this->category))
            return " < Nessuna > ";
        else
            return " < ".$this->category->name." > "; 
    }
}
