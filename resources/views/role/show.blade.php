@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/role/">Role</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
    <label for="id" class="col-md-4 col-form-label text-md-right">{{ __('Id') }}</label>

    <div class="col-md-6">
        <input id="id" type="text" class="form-control" name="id"
            value="{{ $role->id }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="role_name" class="col-md-4 col-form-label text-md-right">{{ __('Role Name') }}</label>

    <div class="col-md-6">
        <input id="role_name" type="text" class="form-control" name="role_name"
            value="{{ $role->role_name }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="role_description" class="col-md-4 col-form-label text-md-right">{{ __('Role Description') }}</label>

    <div class="col-md-6">
        <input id="role_description" type="text" class="form-control" name="role_description"
            value="{{ $role->role_description }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="right" class="col-md-4 col-form-label text-md-right">{{ __('Right') }}</label>

    <div class="col-md-6">
        <input id="right" type="text" class="form-control" name="right"
            value="{{ $role->right }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="deleted_at" class="col-md-4 col-form-label text-md-right">{{ __('Deleted At') }}</label>

    <div class="col-md-6">
        <input id="deleted_at" type="text" class="form-control" name="deleted_at"
            value="{{ $role->deleted_at }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="created_at" class="col-md-4 col-form-label text-md-right">{{ __('Created At') }}</label>

    <div class="col-md-6">
        <input id="created_at" type="text" class="form-control" name="created_at"
            value="{{ $role->created_at }}" disabled>
    </div>
</div>
<div class="form-group row">
    <label for="updated_at" class="col-md-4 col-form-label text-md-right">{{ __('Updated At') }}</label>

    <div class="col-md-6">
        <input id="updated_at" type="text" class="form-control" name="updated_at"
            value="{{ $role->updated_at }}" disabled>
    </div>
</div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="/role/{{ $role->id }}/edit" class="btn btn-primary">
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