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