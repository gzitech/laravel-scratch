@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/site/">Site</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Site Name') }}</label>

                        <div class="col-md-6">
                            <div class="input-group">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $site->name }}"
                                    disabled>
                                <div class="input-group-append">
                                    <div class="input-group-text">.{{ config('site.default_domain') }}</div>
                                </div>
                            </div>
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
                        @right('site.update')
                        <a href="/user/create" role="button" class="btn btn-primary btn-sm" @vue
                            @click.prevent="showUserCreateForm" @endvue>{{ __('Add Users to Site') }}</a>
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
                                    @right('site.update')
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