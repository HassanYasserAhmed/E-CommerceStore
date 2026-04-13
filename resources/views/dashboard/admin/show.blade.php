@extends('layouts.dashboard')

@section('title',$admin->name)
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">admins</li>
    <li class="breadcrumb-item active">{{ $admin->name }}</li>
@endsection

<base href='/public'>
 @section('content')
    <div class="card">
        <div class="card-body">
            <h3>{{ $admin->name }}</h3>
            <p>{{ $admin->email }}</p>
        </div>

        <div class="card-footer">
             <h4>Roles</h4>
        @foreach ($admin->roles as $role)
        <div class="form-check">
            <input type="checkbox" id="{{ $role->id }}" checked disabled>
            <label for="{{ $role->id }}">{{ $role->name }}</label>
        </div>
        @endforeach
    </div>
@endsection