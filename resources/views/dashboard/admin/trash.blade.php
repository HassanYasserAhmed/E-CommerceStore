@extends('layouts.dashboard')

@section('title','Trashed categories')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">categories</li>
    <li class="breadcrumb-item active">Trashed</li>
@endsection

 <base href="/public"> @section('content')

 <form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">
    <input type="text" name="name"  value = "{{ request('name') }}" placeholder="name" class="mx-2"/>
    <select name="status" class="form-control mx-2" >
        <option value="">All</option>
        <option value="active" @selected(request('status') == 'active')>Active</option>
        <option value="archived" @selected(request('status') == 'archived')>Archived</option>
    </select>
    <button type="submit" class="btn btn-dark mt-2">Search</button>
 </form>
 <div class="mb-5">
    <a href={{ route('categories.index') }} class="btn btn-sm btn-outline-primary">Back</a>
 </div>
 <x-alert type="success"/>
 <x-alert type="info"/>
    <table class="table">
        <thead>
            <tr>
                <td>ID</td>
                <td>Image</td>
                <td>Name</td>
                <td>Deleted At</td>
                <td></td>
                <td colspan="2"></td>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
            <tr>
            <td>{{ $category->id }}</td>
                <td>

                <img src="{{ asset('storage/images_folder/'.$category->image) }}" />
                
                </td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->deleted_at }}</td>
           <td>
                <form action="{{ route('categories.restore',$category->id) }}" method="post">
                    @csrf
                    @method('put')
                  <button type="submit" class="btn btn-sm btn-info">Restore</button>
                </form>
            </td>
            <td>
                <form action="{{ route('categories.forceDelete',$category->id) }}" method="post">
                    @csrf
                    @method('delete')
                  <button type="submit" class="btn btn-sm btn-danger">Force Delete</button>
                </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7">No Categories Found</td>
          </tr>
          @endforelse
        </tbody>
    </table>
    {{ $categories->withQueryString()->appends(['search'=>'yes'])->links() }}
@endsection