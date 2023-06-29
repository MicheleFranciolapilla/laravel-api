@extends('admin.admin_layout')

@section('admin_section')
    Add Project
@endsection
    
@section('admin_menu_items')
    <li>
        <a href="{{ route('admin.projects.index') }}">Torna alla lista progetti</a>
    </li>
    <li>
        <a href="{{ route('admin.dashboard') }}">Torna alla dashboard</a>
    </li>
@endsection

@section('admin_view_space')
    <div id="view_space" class="offset-1 col-9 p-2 border border-3 border-info">
        <h2 class="text-center">Inserisci un nuovo progetto</h2>
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="m-2 p-2">
            @csrf

            <div class="form-group p-3 my-1">
                <label for="title_input" class="form-label text-primary fs-5">Titolo <span class="text-warning">(CAMPO RICHIESTO)</span></label>
                <input id="title_input" class="form-control @error('title') is-invalid @enderror" type="text" name="title" maxlength="50" placeholder="Digita quì il titolo..." required>
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

            <div class="form-group p-3 my-1">
                <label for="description_input" class="form-label text-primary fs-5">Descrizione <span class="text-warning">(CAMPO RICHIESTO)</span></label>
                <textarea id="description_input" class="form-control @error('description') is-invalid @enderror" name="description" rows="2" required></textarea>
                @error('description')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group p-3 my-1">
                <label for="url_input" class="form-label text-primary fs-5">Indirizzo host <span class="text-info">(CAMPO NON OBBLIGATORIO)</span></label>
                <textarea id="url_input" class="form-control @error('host_url') is-invalid @enderror" name="host_url" rows="1"></textarea>
                @error('host_url')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between">
                <div class="form-group p-3 my-1">

                    <label for="img_input" class="form-label text-primary fs-5">Immagine di copertina <span class="text-info">(CAMPO NON OBBLIGATORIO)</span></label>
                    <input id="img_input" class="form-control-file @error('cover_img') is-invalid @enderror" type="file" name="cover_img" maxlength="255" onchange="refresh_img(event)">
                    <button id="reset_img_btn" class="btn btn-dark" onclick="reset_img(event)">Rimuovi Immagine</button>
                    @error('cover_img')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="p-1 my-4">
                        <label for="category_select" class="form-label text-primary fs-5">Seleziona una categoria</label>
                        <select id="category_select" name="category_id" class="form-select @error('category_id') is-invalid @enderror" aria-label="Category_select">
                            <option value="" selected>Nessuna categoria</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
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

                    <div class="form-group">
                        <h5 class="text-primary mb-2">Eventuali tecnologie utilizzate nel progetto:</h5>
                        @error('technologies')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        @foreach ($technologies as $tech)
                            <div class="form-check form-switch">
                                <label for="tech_check_{{ $tech->id }}" class="form-check-label mx-3">{{ $tech->name }}</label>
                                <input id="tech_check_{{ $tech->id }}" type="checkbox" class="form-check-input" name="technologies[]" value="{{ $tech->id }}">
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="text-center m-5">
                    <h6>Anteprima immagine:</h6>
                    <div class="thumb_form">
                        <img id="img_thumb" src={{ $no_img }} alt="Immagine">
                    </div>
                </div>
            </div>

            <div class="form_buttons py-4">
                <a href="{{ route('admin.projects.index') }}" id="close_btn" class="btn btn-secondary" type="button">Abbandona</a>
                <button id="reset_btn" class="btn btn-warning" type="reset" onclick="reset_img(event, false)">Reset</button>
                <button id="submit_btn" class="btn btn-primary" type="submit">Conferma e salva</button>
            </div>
        </form>
    </div>
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

    </script>
@endsection

