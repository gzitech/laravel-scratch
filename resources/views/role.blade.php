@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="nav mr-auto">
                    </div>
                    <div class="nav ml-auto">
                        @right('role.edit')
                        <a href="/role/create" role="button" class="btn btn-primary btn-sm">Create</a>
                        @endright
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th id="confirm-key" scope="col">Role Name</th>
                                <th scope="col">Role Description</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <th scope="row">{{ $role->id }}</th>
                                <td>{{ $role->role_name }}</td>

                                <td>{{ $role->role_description }}</td>
                                <td class="text-md-right">
                                    <a href="/role/{{ $role->id }}" title="Show" class="btn btn-outline-primary"><i
                                            class="fa fa-user-o"></i></a>
                                    @right('right.edit')
                                    <a href="/role/right/{{ $role->id }}" title="Right"
                                        class="btn btn-outline-primary"><i class="fa fa-lock"></i></a>
                                    @endright
                                    @right('role.edit')
                                    <a href="/role/{{ $role->id }}/edit" title="Edit" class="btn btn-outline-primary"><i
                                            class="fa fa-pencil"></i></a>
                                    <a href="/role/{{ $role->id }}/destroy" title="Destroy {{ $role->role_name }}"
                                       class="btn btn-outline-danger"><i class="fa fa-trash-o"></i></a>
                                    @endright
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($roles->previousPageUrl() || $roles->nextPageUrl())
                <div class="card-footer d-flex">
                    <div class="nav mr-auto">

                    </div>
                    <div class="nav ml-auto">
                        {{ $roles->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
