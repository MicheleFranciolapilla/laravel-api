@extends('admin.admin_layout')

@section('admin_section')
    Show Project : {{ $project->slug }}
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
        <h2 class="text-center">Dettagli del progetto</h2>

        <div class="my-3 px-3 py-2 border-bottom border-black">
            <h6>Titolo:</h6>
            <h4 class="ps-3 text-primary">{{$project->title}}</h4>
        </div>

        <div class="my-3 px-3 py-2 border-bottom border-black">
            <h6>Descrizione:</h6>
            <h4 class="ps-3 text-secondary">{{$project->description}}</h4>
        </div>

        <div class="my-3 px-3 py-2 border-bottom border-black">
            <h6>Categoria del progetto: <span class="fs-4 ps-3 text-secondary">{{$project->get_category_string()}}</span>
            </h6>
        </div>

        <div class="my-3 px-3 py-2 border-bottom border-black">
            <h6>Tecnologie utilizzate nel progetto:</h6>
            <div>
                @forelse ($project->technologies as $technology)
                    <div class="tech_viewer">
                        <span class="fs-4 d-flex justify-content-start align-items-center w-25 text-primary">{!! $technology->icon !!}</span>
                        <span class="fs-4 d-flex justify-content-start align-items-center w-50 text-secondary">{{ $technology->name }}</span>
                    </div>
                @empty
                    <h4>Nessuna tecnologia utilizzata</h4>
                @endforelse
            </div>
        </div>

        <div class="my-3 px-3 py-2 border-bottom border-black">
            <h6>Indirizzo Host:</h6>
            <h4 class="ps-3 text-secondary">{{ ($project->host_url) ? ($project->host_url) : ("Non Presente")}}</h4>
        </div>

        <div class="my-3 px-3 py-2 border-bottom border-black">
            <h6>Immagine di copertina:</h6>
            <div class="img_box">
                <img src="{{ ($project->cover_img) ? (asset('storage/'.$project->cover_img)) : ($no_img)}}" alt="Immagine di copertina">
            </div>
        </div>

        <div class="form_buttons py-4">
            <a href="{{ route('admin.projects.index') }}" id="close_btn" class="btn btn-secondary" type="button">Chiudi</a>
            <a href="{{ route('admin.projects.edit',$project) }}" id="close_btn" class="btn btn-warning" type="button">Modifica</a>
            <form action="{{ route('admin.projects.destroy',$project) }}" method="POST" enctype="multipart/form-data" class="m-0">
                @csrf 
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Sei certo di voler procedere con la cancellazione del progetto?')">Cancella</button>
            </form>
        </div>
@endsection