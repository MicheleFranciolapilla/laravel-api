<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Admin\Project as Project;
use App\Rules\Admin\NullableUrlRule as NullableUrlRule;
use App\Rules\Admin\NullableImageRule as NullableImageRule;
use Illuminate\Validation\Rule as Rule;

class UpdateProjectRequest extends FormRequest
{
    public      function authorize()
    {
        return true;
    }

    protected   function prepareForValidation()
    {
        $title = $this->input('title');
        $slug = Project::title_slug($title);
        $this->merge(['slug' => $slug]);
    }

    public      function rules()
    {
        // La validazione "unique" sul titolo è spostata direttamente sullo slug
        // L'attributo "nullable" per url ed immagine è valutato direttamente all'interno delle relative nuove regole
        return [
            'title'         =>  ['required', 'max:50'],
            'slug'          =>  Rule::unique('projects')->ignore($this->project),
            'description'   =>  'required',
            'host_url'      =>  [new NullableUrlRule],
            'cover_img'     =>  [new NullableImageRule, 'max:2048'],
            'category_id'   =>  'nullable|exists:categories,id',
            'technologies'  =>  'exists:technologies,id'
        ];
    }

    public      function messages()
    {
        return [
            'title.max'             =>  'Titolo troppo lungo (lunghezza massima: 50 caratteri',
            'title.unique'          =>  'Il titolo digitato esiste già.',
            'slug.unique'           =>  'Il titolo digitato esiste già (al netto di spazi, maiuscole o minuscole).',
            'description.required'  =>  'Il campo "descrizione" è obbligatorio!',
            'cover_img.max'         =>  "Il peso dell'immagine selezionata eccede il massimo consentito (2MB)",
            'category_id.exists'    =>  'Categoria inesistente o non consentita',
            'technologies.exists'   =>  'Salvataggio non riuscito a causa della selezione di tecnologie inesistenti o non consentite, ORA RIMOSSE!'
        ];
    }
}