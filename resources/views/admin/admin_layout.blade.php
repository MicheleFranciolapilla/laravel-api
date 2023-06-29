@extends('layouts.app')

@section('page_title')
    Admin | @yield('admin_section')
@endsection
    
@section('content')
    <div class="container d-flex mt-5">
        <div id="admin_menu_box" class="col-2 bg-dark px-2 border border-3 border-info align-self-start">
            <h4 class="text-white-50 text-center mt-2 mb-3">Admin Menu</h4>
            <ul id="admin_menu" class="d-flex flex-column px-2 row-gap-2">
                <li>
                    <a href="">Statistiche</a>
                </li>
                @yield('admin_menu_items')
            </ul>
        </div>
        @yield('admin_view_space')
    </div>
@endsection
