<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\Project as Project;
use GrahamCampbell\ResultType\Success;

class ApiProjectController extends Controller
{
    private     $max_page_size  = 10; 
    private     $page_size      = 6; 

    function index(Request $request)
    {
        // Questo metodo riceve una richiesta di dati dal front-end; tutti i dati della richiesta sono elementi del parametro $request. Nella richiesta potrebbero essere presenti, oltre al numero di pagina, anche ulteriori informazioni indicanti eventuali filtraggi da effettuare sulla base delle tabelle relazionate con la tabella principale dei progetti.
        // Si inizia acquisendo tutti i record della tabella Projects (model Project), incluse le relazioni con le tabelle Categories (metodo relazionale category) e Technologies (metodo relazionale technologies).
        $requested_projects = Project::with(['category', 'technologies']);
        // Segue un controllo sulla richiesta del front-end con conseguente, eventuale filtraggio....
        // Se è richiesto un filtraggio sulla base della categoria specifca allora, alla collezione di progetti già acquisita, si applica la seguente restrizione:
        // lasciare nella collezione solo quei progetti per i quali il valore nella colonna "category_id" coincide con il category_id richiesto dal front-end
        if ($request->has('category_id'))
            $requested_projects->where('category_id', $request->category_id);
        //Segue un secondo controllo sulla richiesta del front-end con conseguente, eventuale filtraggio.....
        // Se dal front-end è stato richiesto anche un filtraggio sulle tecnologie presenti nel progetto si applicano ulteriori restrizioni ai dati...
        // NB. Tanto "category_id", quanto "tech_slugs" e simili, sono nomi delle chiavi di attributo aggiuntivo stabiliti dal front-end
        if ($request->has('tech_slugs'))
        {
            // Si inizia definendo un array in cui si "esplode" la stringa del valore dell'attributo proveniente dal front-end.
            $technology_slugs = explode(",", $request->tech_slugs);
            // Segue il filtraggio vero e proprio:
            // il primo parametro del "wherehas" indica a quale metodo relazionale del model Project fare riferimento;
            // il secondo parametro è una call back function il cui parametro è la collezione di progetti; lo "use" consente alla call back function di utilizzare l'array degli slugs nella sua logica. Nella logica della funzione si filtrano i progetti sulla base del fatto che gli slug delle tecnologie coincidano con quelle presenti nell'array, come richiesto dal front-end.
            // N.B. IL FILTRAGGIO IN QUESTIONE E' DI TIPO "OR", NEL SENSO CHE LA LOGICA SOTTOSTANTE NON RICERCA LA CONTEMPORANEA PRESENZA DI TUTTE LE TECNOLOGIE RICHIESTE BENSI' LA PRESENZA DI ALMENO UNA TRA ESSE.
            $requested_projects->whereHas('technologies', function($requested_projects) use ($technology_slugs)
                {
                    $requested_projects->wherein('slug', $technology_slugs);
                });
        }
        // Segue un altro controllo sulla richiesta del front-end.
        // QUESTA EVENTUALE RICHIESTA E' ALTERNATIVA ALLE PRECEDENTI
        // AL MOMENTO NON VIENE ESEGUITA ALCUNA VALIDAZIONE SUL TESTO DA CERCARE
        // Se nella richiesta è presente la chiave "search_str" significa che nel front-end è stato digitato del testo e lo si vuole cercare tra i progetti, nella sola colonna titolo o in entrambe le colonne titolo e descrizione, a seconda del valore di un'ulteriore chiave denominata "only_title"
        if ($request->has('search_str'))
        {
            $lower_str = strtolower($request->search_str);
            if (strtolower($request->only_title) == "no")
                // Caso di ricerca in entrambe le colonne: titolo e descrizione
                $requested_projects->where(function ($query) use ($lower_str) 
                    {
                        $query->whereRaw('LOWER(title) LIKE ?', ['%'.$lower_str.'%'])->orWhereRaw('LOWER(description) LIKE ?', ['%'.$lower_str.'%']);
                    });
            else
                // Caso di ricerca nella sola colonna dei titoli
                $requested_projects->whereRaw('LOWER(title) LIKE ?', ['%'.$lower_str.'%']);
        }
        // Al termine di tutti gli eventuali filtraggi si associano alla variabile $projects tutti i progetti rimasti in $requested_projects, impaginandoli
        $projects = $requested_projects->paginate($this->page_size);
        if ($projects->isNotEmpty())
            return response()->json([
                                        'success'   => true,
                                        'projects'  => $projects
                                    ]);
        else
            return response()->json([
                                        'success'   => false,
                                        'error_msg' => "Progetto/i non trovato/i"
                                    ])->setStatusCode(404);
    }

    function show($slug)
    {
        $project = Project::with(['category', 'technologies'])->where('slug', $slug)->first();
        if ($project)
            return response()->json([
                                        'success'   => true,
                                        'project'   => $project
                                    ]);
        else
            return response()->json([
                                        'success'   => false,
                                        'error'     => "Il progetto non esiste"
                                    ])->setStatusCode(404);
    }

    function get_page_size()
    {
        return response()->json([
                                    'success'   =>  true,
                                    'page_size' =>  $this->page_size
                                ]);
    }

    function set_page_size($new_page_size)
    {
        $success =  false;
        if (is_int($new_page_size) && ($new_page_size <= $this->max_page_size))
        {
            $success = true;
            $this->page_size = $new_page_size;
        }
        return response()->json([ 'success' => $success ]);
    }
}
