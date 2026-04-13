@extends('layouts.dashboard')

<base href='/public'>
 @section('content')
<form action="{{ route("categories.store") }}" method="post" enctype="multipart/form-data">
    @csrf
    @include('dashboard.categories._form')
</form>
@endsection