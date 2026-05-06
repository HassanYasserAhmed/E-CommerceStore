@extends('layouts.dashboard')

@section('title','categories')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">categories</li>
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
    @if(Auth::user()->can('categories.create'))
    <a href={{ route('categories.create') }} class="btn btn-sm btn-outline-primary">create</a>
    @endif
    <a href={{ route('categories.trash') }} class="btn btn-sm btn-outline-secondary">Trashed</a>
 </div>
 <x-alert type="success"/>
 <x-alert type="info"/>
    <table class="table">
        <thead>
            <tr>
                <td>ID</td>
                <td>Image</td>
                <td>Name</td>
                <td>Parent</td>
                <td>Products #</td>
                <td>Created At</td>
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
            <td><a href="{{ route('categories.show',$category->id) }}">{{ $category->name }}</a></td>
            <td>{{ $category->parent->name }}</td>
            <td>{{ $category->products->count() }}</td>
            <td>{{ $category->created_at }}</td>
            <td>
                @can('categories.edit')
                <a href="{{ route('categories.edit',$category->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                @endcan
            </td>
            <td>
                @can('categories.delete')
                <form action="{{ route('categories.destroy',$category->id) }}" method="post">
                    @csrf
                    @method('delete')
                  <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
                @endcan
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