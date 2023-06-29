<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Project as Project;
use App\Models\Admin\Category as Category;
use App\Models\Admin\Technology as Technology;

use App\Http\Requests\Admin\StoreProjectRequest as StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest as UpdateProjectRequest;

use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    private $backup_img = "https://cdn.vectorstock.com/i/preview-1x/82/99/no-image-available-like-missing-picture-vector-43938299.jpg";

    public  function get_backup_img() : string
    {
        return $this->backup_img;
    }

    public function index()
    {
        $all_projects = Project::All();
        $no_img = $this->get_backup_img();
        return view('admin.pages.projects_index', compact('all_projects', 'no_img'));
    }

    public function create()
    {
        $categories = Category::All();
        $technologies = Technology::All();
        $no_img = $this->get_backup_img();
        return view('admin.pages.projects_create', compact('categories', 'technologies', 'no_img'));
    }

    public function store(StoreProjectRequest $request)
    {
        $form_data = $request->validated();
        // Per non avere elementi vuoti o indefiniti nella colonna delle immagini, si setta il valore di default a "null"
        if (!isset($form_data['cover_img']))
            $form_data['cover_img'] = null;
        // Se nella request è presente un file (immagine poichè validato), lo si salva nello storage
        if ($request->hasFile('cover_img'))
        {
            $img_path_for_db = Storage::disk('public')->put('Project_images',$request->cover_img);
            $form_data['cover_img'] = $img_path_for_db;
        }
        // Equivalente a $new_project = new Project(); + $new_project->fill($form_data); + $new_project->save();
        $new_project = Project::create($form_data);
        // Se nella request ci sono delle tecnologie collegate le si inserisce nella tabella pivot
        if ($request->has('technologies'))
            $new_project->technologies()->attach($request->technologies);
        $cat_str = $new_project->get_category_string();
        return redirect()->route('admin.projects.index')
            ->with('success',"Il progetto <span class='text-info'>$new_project->title</span>, di categoria <span class='text-white-50'>$cat_str</span> è stato aggiunto alla collezione!");
    }

    public function show(Project $project)
    {
        $no_img = $this->get_backup_img();
        return view('admin.pages.projects_show', compact('project', 'no_img'));
    }

    public function edit(Project $project)
    {
        $categories = Category::All();
        $technologies = Technology::All();
        $no_img = $this->get_backup_img();
        return view('admin.pages.projects_edit', compact('project', 'categories', 'technologies', 'no_img'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $form_data = $request->validated();
        // Per non avere elementi vuoti o indefiniti nella colonna delle immagini, si setta il valore di default a "null"
        if (!isset($form_data['cover_img']))
            $form_data['cover_img'] = null;
        // Se il progetto, precedentemente alla modifica, aveva una immagine associata la si cancella dallo storage
        if ($project->cover_img)
        {
            Storage::delete($project->cover_img);
        }
        // A prescindere dalla condizione/operazione precedente, se nella request è presente un'immagine, la si salva nello storage
        if ($request->hasFile('cover_img'))
        {
            $img_path_for_db = Storage::disk('public')->put('Project_images',$request->cover_img);
            $form_data['cover_img'] = $img_path_for_db;
        }
        else
            $form_data['cover_img'] = null; 
        $project->update($form_data);
        // A differenza di quanto avviene nella store, nell'update si provvede all'inserimento delle tecnologie nella tabella pivot a prescindere che ve ne siano di selezionate o meno, il che, unitamente all'utilizzo di "sync()" al posto di "attach()" garantisce il corretto aggiornamento con sovrascrittura dei dati precedenti
        $project->technologies()->sync($request->technologies);
        $cat_str = $project->get_category_string();
        return redirect()->route('admin.projects.index')
        ->with('success',"Il progetto <span class='text-info'>$project->title</span>, di categoria <span class='text-white-50'>$cat_str</span> è stato aggiornato!");
    }

    public function destroy(Project $project)
    {
        // La cancellazione del progetto dal database è accompagnata dalla rimozione dallo storage dell'immagine eventualmente associata
        if ($project->cover_img)
            Storage::delete($project->cover_img);
        $project->delete();
        // Il metodo "cascadeOnDelete" utilizzato nelle relazioni della tabella pivot garantisce automaticamente la cancellazione dei record nella stessa in conseguenza alla cancellazione dell'id corrispondente nella tabella "projects" o "technologies"
        $cat_str = $project->get_category_string();
        return redirect()->route('admin.projects.index')
        ->with('success',"Il progetto <span class='text-info'>$project->title</span>, di categoria <span class='text-white-50'>$cat_str</span> è stato cancellato dalla collezione!");
    }

    public function delete_all()
    {
        // Tutte le operazioni di cancellazione del progetto presenti nel metodo "destroy", vengono quì applicate all'intera collezione di progetti
        $all_projects = Project::All();
        foreach($all_projects as $project)
        {
            if ($project->cover_img)
                Storage::delete($project->cover_img);
            $project->delete();
        }
        return redirect()->back()->with('success',"Tutta la collezione di progetti è stata cancellata!");
    }
}
