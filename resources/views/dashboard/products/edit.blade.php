@extends('layouts.dashboard')

<base href='/public'>
 @section('content')
<form action="{{ route("products.update",$product->id) }}" method="post" enctype="multipart/form-data">
    @method('put')
    @csrf
   @include('dashboard.products._form',[
   'button_label' =>'update'
   ])
</form>
@endsection