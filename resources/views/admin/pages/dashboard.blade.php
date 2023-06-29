@extends('admin.admin_layout')

@section('admin_section')
    Dashboard
@endsection
    
@section('admin_menu_items')
    <li>
        <a href="{{ route('admin.projects.index') }}">Carica lista progetti</a>
    </li>
@endsection