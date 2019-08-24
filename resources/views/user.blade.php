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
                        @right('user.edit')
                        <a href="/user/create" role="button" class="btn btn-primary btn-sm">Create</a>
                        @endright
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
                                    <a href="/user/{{ $user->id }}" title="Show" class="btn btn-outline-primary"><i
                                            class="fa fa-user-o"></i></a>
                                    @right('user.edit')
                                    <a href="/user/{{ $user->id }}/edit" title="Edit" class="btn btn-outline-primary"><i
                                            class="fa fa-pencil"></i></a>
                                    <a href="/user/{{ $user->id }}/destroy" title="Destroy"
                                        class="btn btn-outline-danger"><i class="fa fa-trash-o"></i></a>
                                    @endright
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
        </div>
    </div>
</div>
@endsection