@extends('admin.layouts.back_end_layout')

@section('page_title')
    Add New Project
@endsection

@section('page_role')
    Caricamento nuovo progetto
@endsection

@section('back_end_menu_top_items')
    <li>
        <a href="#" class="back_end_menu_item" 
         onclick="force_event(event, 'reset_btn')">
            Resetta il form
        </a>
    </li>
    <li>
        <a href="#" class="back_end_menu_item" 
         onclick="force_event(event, 'submit_btn')">
            Conferma e salva
        </a>
    </li>
    <li class="line"></li>
@endsection
    
@section('view_content')
    <form 
     action="{{ route('admin.projects.store') }}" 
     method="POST" 
     enctype="multipart/form-data">
     @csrf

        <div id="back_end_view_top_row" class="d-flex justify-content-between">
            <div id="title_form" class="form-group">
                <label for="title_input" class="form-label text-primary fs-5">
                    Titolo del progetto<span class="text-warning"> (CAMPO RICHIESTO)</span>
                </label>
                <input 
                 id="title_input" 
                 class="form-control @error('title') is-invalid @enderror" 
                 type="text" 
                 name="title" 
                 maxlength="50" 
                 placeholder="Digita quì il titolo..." 
                 required>
                @if ($errors->has('title'))
                    @error('title')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                @else 
                    @error('slug')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                @endif
            </div>

            <div id="host_url_form" class="form-group">
                <label for="url_input" class="form-label text-primary fs-5">
                    Indirizzo host<span class="text-info"> (CAMPO NON OBBLIGATORIO)</span>
                </label>
                <textarea 
                 id="url_input" 
                 class="form-control @error('host_url') is-invalid @enderror" 
                 name="host_url" 
                 rows="1">
                </textarea>
                @error('host_url')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="form-group mt-3">
            <label for="description_input" class="form-label text-primary fs-5">
                Descrizione<span class="text-warning"> (CAMPO RICHIESTO)</span>
            </label>
            <textarea 
             id="description_input" 
             class="form-control @error('description') is-invalid @enderror" name="description" 
             rows="2" required>
            </textarea>
            @error('description')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div id="back_end_view_bottom_row" class="d-flex justify-content-between mt-3">
            <div id="technologies_check" class="form-group px-1 pb-2">
                <h5 class="text-primary mt-1 mb-2">
                    Tecnologie utilizzate:
                </h5>
                @error('technologies')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
                @foreach ($technologies as $tech)
                    <div class="form-check form-switch">
                        <label for="tech_check_{{ $tech->id }}" class="form-check-label mx-3 text-light">
                            {{ $tech->name }}
                        </label>
                        <input 
                         id="tech_check_{{ $tech->id }}" 
                         type="checkbox" 
                         class="form-check-input" 
                         name="technologies[]" 
                         value="{{ $tech->id }}">
                    </div>
                @endforeach
            </div>

            <div id="category_select">
                <label for="category_select" class="form-label text-primary fs-5">
                    Seleziona una categoria
                </label>
                <select 
                 id="category_select" 
                 name="category_id" 
                 class="form-select @error('category_id') is-invalid @enderror" aria-label="Category_select">
                    <option 
                     value="" 
                     selected>
                        Nessuna categoria
                    </option>
                    @foreach ($categories as $category)
                        <option 
                         value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div id="image_area" class="p-2 border border-3 border-info">
                <div id="img_input_group" class="form-group h-100">
                    <div>
                        <label for="img_input" class="form-label text-primary fs-5">
                            Immagine di copertina 
                        </label>
                        <h6 class="text-info">(CAMPO NON OBBLIGATORIO)</h6>
                    </div>
                    <input 
                     id="img_input" 
                     class="form-control-file @error('cover_img') is-invalid @enderror"
                     type="file" 
                     name="cover_img" 
                     maxlength="255" 
                     onchange="refresh_img(event)">
                    <button 
                     id="reset_img_btn" 
                     class="btn btn-dark d-block mt-3" 
                     onclick="reset_img(event)">
                        Rimuovi Immagine
                    </button>
                    @error('cover_img')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div id="img_preview_box" class="d-flex flex-column text-center me-3">
                    <h6>Anteprima immagine:</h6>
                    <div class="thumb_form">
                        <img id="img_thumb" src={{ $no_img }} alt="Immagine">
                    </div>
                </div>
            </div>
        </div>

        <div class="form_buttons d-flex justify-center mt-3">
            <button 
             id="reset_btn" 
             class="btn btn-warning" 
             type="reset" 
             onclick="reset_img(event, false)">
                Reset
            </button>
            <button 
             id="submit_btn" 
             class="btn btn-primary" 
             type="submit">
                Conferma e salva
            </button>
        </div>
    </form>
 
    {{-- Il seguente codice php permette di creare uno script js in cui si assegna alla variabile no_img (variabile JS) il valore della variabile $no_img (variabile PHP) --}}
    @php
        echo '<script>';
        echo    'var no_img = "' . $no_img . '";';
        echo '</script>';
    @endphp
    <script>
        function reset_img(event, prev_def = true)
        {
            let input = document.getElementById('img_input');
            let image = document.getElementById('img_thumb');
            input.value = '';
            image.src = no_img;
            if (prev_def)
            {
                console.log("prevent default");
                event.preventDefault();
            }
        }

        function refresh_img(event)
        {
            let input = event.target;
            let image = document.getElementById('img_thumb');
            let last_loaded_img = image.src;
            console.log('input.value cambiato');
            if (input.files && input.files[0]) 
            {
                let file = input.files[0];
                let reader = new FileReader();
                console.log(input.files);
                if (file.type.match('image.*')) 
                {
                    reader.onload = function(e) 
                    {
                        image.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } 
                else 
                {
                    image.src = last_loaded_img;
                }
            } 
            else 
            {
                image.src = last_loaded_img;
            }
        }

        function force_event(event, btn_id)
        {
            event.preventDefault();
            btn_to_force = document.getElementById(btn_id);
            btn_to_force.click();
        }
    </script>
@endsection
