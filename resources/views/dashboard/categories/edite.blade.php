@extends('layouts.dashboard')

<base href='/public'>
 @section('content')
<form action="{{ route("categories.update",$category->id) }}" method="post" enctype="multipart/form-data">
    @method('put')
    @csrf
   @include('dashboard.categories._form',[
   'button_label' =>'update'
   ])
</form>
@endsection