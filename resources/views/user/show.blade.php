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
    <label for="id" class="col-md-4 col-form-label text-md-right">{{ __('Id') }}</label>

    <div class="col-md-6">
        <input id="id" type="text" class="form-control" name="id"
            value="{{ $user->id }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

    <div class="col-md-6">
        <input id="first_name" type="text" class="form-control" name="first_name"
            value="{{ $user->first_name }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

    <div class="col-md-6">
        <input id="last_name" type="text" class="form-control" name="last_name"
            value="{{ $user->last_name }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

    <div class="col-md-6">
        <input id="email" type="text" class="form-control" name="email"
            value="{{ $user->email }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="email_verified_at" class="col-md-4 col-form-label text-md-right">{{ __('Email Verified At') }}</label>

    <div class="col-md-6">
        <input id="email_verified_at" type="text" class="form-control" name="email_verified_at"
            value="{{ $user->email_verified_at }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

    <div class="col-md-6">
        <input id="password" type="text" class="form-control" name="password"
            value="{{ $user->password }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="remember_token" class="col-md-4 col-form-label text-md-right">{{ __('Remember Token') }}</label>

    <div class="col-md-6">
        <input id="remember_token" type="text" class="form-control" name="remember_token"
            value="{{ $user->remember_token }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="right" class="col-md-4 col-form-label text-md-right">{{ __('Right') }}</label>

    <div class="col-md-6">
        <input id="right" type="text" class="form-control" name="right"
            value="{{ $user->right }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="deleted_at" class="col-md-4 col-form-label text-md-right">{{ __('Deleted At') }}</label>

    <div class="col-md-6">
        <input id="deleted_at" type="text" class="form-control" name="deleted_at"
            value="{{ $user->deleted_at }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="created_at" class="col-md-4 col-form-label text-md-right">{{ __('Created At') }}</label>

    <div class="col-md-6">
        <input id="created_at" type="text" class="form-control" name="created_at"
            value="{{ $user->created_at }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="updated_at" class="col-md-4 col-form-label text-md-right">{{ __('Updated At') }}</label>

    <div class="col-md-6">
        <input id="updated_at" type="text" class="form-control" name="updated_at"
            value="{{ $user->updated_at }}" disabled>
    </div>
</div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="/user/{{ $user->id }}/edit" class="btn btn-primary">
                                {{ __('Edit') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection