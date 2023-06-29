@extends('admin.admin_layout')

@section('admin_section')
    Projects List
@endsection

@section('admin_menu_items')
    <li>
        <a href="{{ route('admin.projects.create') }}">Aggiungi progetto</a>
    </li>
    @if (count($all_projects) !== 0)
    <li>
        <form action="{{ route('admin.projects.delete_all') }}" method="POST" class="m-0 p-0">
            @csrf
            @method('DELETE')
            <button id="delete_all_btn" class="ps-0" type="submit" onclick="return confirm('Sei certo di voler cancellare tutto?')">Cancella tutti</button>
        </form>
    </li>
    @endif
    <li>
        <a href="{{ route('admin.dashboard') }}">Torna alla dashboard</a>
    </li>
@endsection

@section('admin_view_space')

    {{-- @if (Session::has('success'))
        <div id="message_area" class="px-5 py-3 my-3 border border-3 border-info rounded-3 bg-success">
            <h3 class="text-info">{!! Session::get('success') !!}</h3>
        </div>
        <script>
            clean_msg();
        </script>
    @endif --}}

    <div id="view_space" class="offset-1 col-9 p-2 border border-3 border-info">
        @forelse ($all_projects as $project)
            @if ($loop->first)
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Immagine</th>
                            <th scope="col">Titolo</th>
                            <th scope="col">Descrizione</th>
                            <th scope="col">Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
            @endif 
                        <tr>
                            <th scope="row">{{ $project->id }}</th>
                            <td>
                                <div class="thumb">
                                    <img src="{{ ($project->cover_img) ? (asset('storage/'.$project->cover_img)) : ($no_img)}}" alt="Miniatura">
                                </div>
                            </td>
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->description }}</td>
                            <td> 
                                <div class="actions_group d-flex justify-content-between align-items-center column-gap-2">
                                    <a href="{{ route('admin.projects.show',$project) }}" class="action"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('admin.projects.edit',$project) }}" class="action"><i class="fa-solid fa-pencil"></i></a>
                                    <form action="{{ route('admin.projects.destroy',$project) }}" method="POST" enctype="multipart/form-data" class="m-0">
                                        @csrf 
                                        @method('DELETE')
                                        <button class="action" id="delete_submit" type="submit" onclick="return confirm('Sei certo di voler procedere con la cancellazione del progetto?')">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
            @if ($loop->last)
                    </tbody>
                </table>
            @endif

        @empty
            <h2 class="text-center text-warning">Non è presente alcun progetto nel database. Collezione vuota!</h2>
        @endforelse
    </div>
@endsection

{{-- <script>
    function clean_msg()
    {
        let msg_area = document.getElementById('message_area');
        setTimeout(() => { msg_area.classList.add('d-none') }, 5000);
    }
</script> --}}