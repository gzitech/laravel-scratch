@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/role/">Role</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $role->role_name }}</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="role_name"
                            class="col-md-4 col-form-label text-md-right">{{ __('Role Name') }}</label>
                        <div class="col-md-6">
                            <input id="role_name" type="text" class="form-control" name="role_name"
                                value="{{ $role->role_name }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role_description"
                            class="col-md-4 col-form-label text-md-right">{{ __('Role Description') }}</label>
                        <div class="col-md-6">
                            <input id="role_description" type="text" class="form-control" name="role_description"
                                value="{{ $role->role_description }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            @right('role.edit')
                            <a href="/role/{{ $role->id }}/edit" class="btn btn-primary">
                                {{ __('Edit') }}
                            </a>
                            @endright
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex">
                    <div class="nav mr-auto">
                        Users
                    </div>
                    <div class="nav ml-auto">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-md-right">

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($users->previousPageUrl() || $users->nextPageUrl())
                <div class="card-footer d-flex">
                    <div class="nav mr-auto">

                    </div>
                    <div class="nav ml-auto">
                        {{ $users->links() }}
                    </div>
                </div>
                @endif
            </div>
            @right('right.all')
            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Permission</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rights as $right)
                            @right($right->name)
                            <tr>
                                <th scope="row">
                                    <input type="checkbox" name="right[]" value="{{ $right->value }}" disabled
                                        {{ ($role->right & $right->value) ? "checked" : "" }}>
                                </th>
                                <td>{{ __("right." . $right->name) }}</td>
                                <td class="text-md-right">

                                </td>
                            </tr>
                            @endright
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endright
        </div>
    </div>
</div>
@endsection