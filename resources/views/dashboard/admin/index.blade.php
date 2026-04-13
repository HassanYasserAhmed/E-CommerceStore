@extends('layouts.dashboard')

@section('title','admins')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">admins</li>
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
    @if(Auth::user()->can('admins.create'))
    <a href={{ route('admin.create') }} class="btn btn-sm btn-outline-primary">create</a>
    @endif
    <a href={{ route('admin.trash') }} class="btn btn-sm btn-outline-secondary">Trashed</a>
 </div>
 <x-alert type="success"/>
 <x-alert type="info"/>
    <table class="table">
        <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Email</td>
                <td>Role</td>
                <td>Created At</td>
                <td colspan="2"></td>
            </tr>
        </thead>
        <tbody>
            @forelse ($admins as $admin)
            <tr>
            <td>{{ $admin->id }}</td>
            <td><a href="{{ route('admin.show',$admin->id) }}">{{ $admin->name }}</a></td>
            <td>{{ $admin->email }}</td>
            <td></td>
            <td>{{ $admin->created_at }}</td>
            <td>
                @can('admins.edit')
                <a href="{{ route('admin.edit',$admin->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                @endcan
            </td>
            <td>
                @can('admins.delete')
                <form action="{{ route('admin.destroy',$admin->id) }}" method="post">
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
@endsection