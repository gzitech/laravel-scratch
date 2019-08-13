@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/user/">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="first_name"
                            class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                        <div class="col-md-6">
                            <input id="first_name" type="text" class="form-control" name="first_name"
                                value="{{ $user->first_name }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="last_name"
                            class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                        <div class="col-md-6">
                            <input id="last_name" type="text" class="form-control" name="last_name"
                                value="{{ $user->last_name }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="text" class="form-control" name="email" value="{{ $user->email }}"
                                disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            @right('user.update')
                            <a href="/user/{{ $user->id }}/edit" class="btn btn-primary">
                                {{ __('Edit') }}
                            </a>
                            @endright
                        </div>
                    </div>
                </div>
            </div>
            @right('right.list')
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
                            <tr>
                                <th scope="row">
                                    <input type="checkbox" name="right[]" value="{{ $right->value }}" disabled
                                        {{ ($user->right & $right->value) ? "checked" : "" }}>
                                </th>
                                <td>{{ __("right." . $right->name) }}</td>
                                <td class="text-md-right">

                                </td>
                            </tr>
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