@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/role/">Role</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-body">
                    @vue<ssky-role-edit inline-template :role="{{ $role->toJson() }}" :old="{{ json_encode(Session::getOldInput()) }}"
                    :errors="{{ $errors }}">@endvue
                    <form method="POST" action="/role/{{$role->id}}">
                        @csrf
                        @method('PUT')
                        @include('role.edit-form')
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @vue</ssky-role-edit>@endvue
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
