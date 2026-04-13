@extends('layouts.dashboard')

<base href='/public'>
 @section('content')
 <h1 class="h3 mb-4 text-gray-800">Create Role</h1>
<form action="{{ route("roles.store") }}" method="post" enctype="multipart/form-data">
    @csrf
    @include('dashboard.roles._form')
</form>
@endsection