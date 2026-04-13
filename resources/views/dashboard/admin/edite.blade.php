@extends('layouts.dashboard')

<base href='/public'>
 @section('content')
<form action="{{ route("admin.update",$admin->id) }}" method="post" enctype="multipart/form-data">
    @method('put')
    @csrf
   @include('dashboard.admin._form',[
   'button_label' =>'update'
   ])
</form>
@endsection