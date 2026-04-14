@extends('layouts.dashboard')

@section('title','products')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">products</li>
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
    <a href={{ route('products.create') }} class="btn btn-sm btn-outline-primary">create</a>
 </div>
 <x-alert type="success"/>
 <x-alert type="info"/>
    <table class="table">
        <thead>
            <tr>
                <td>ID</td>
                <td>Image</td>
                <td>Name</td>
                <td>Category</td>
                <td>store</td>
                <td>Created At</td>
                <td></td>
                <td colspan="2"></td>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $Product)
            <tr>
            <td>{{ $Product->id }}</td>
                <td>

                <img src="{{ asset('storage/images_folder/'.$Product->image) }}" />
                
                </td>
            <td>{{ $Product->name }}</td>
            <td>{{ $Product->Category->name}}</td>
            <td>{{ $Product->store->name}}</td>
            <td>{{ $Product->created_at }}</td>
            <td>
                @can('edite',$Product)
                <a href="{{ route('products.edit',$Product->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                @endcan
            </td>
            <td>
                @can('destroy',App\Models\Product::class)
                <form action="{{ route('products.destroy',$Product->id) }}" method="post">
                    @csrf
                    @method('delete')
                  <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
                @endcan
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8">No products Found</td>
          </tr>
          @endforelse
        </tbody>
    </table>
    {{ $products->withQueryString()->appends(['search'=>'yes'])->links() }}
@endsection