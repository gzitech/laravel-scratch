@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/right/">{{__('Right')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Create') }}</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-body">
                    @vueif<ssky-right-create inline-template :old="{{ json_encode(Session::getOldInput()) }}" :errors="{{ $errors }}">@vuend
                    <form method="POST" action="/right" @submit="validateRightCreateForm">
                        @csrf
                        @include('right.create-form')
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @vueif</ssky-right-create>@vuend
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
