@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/right/">Right</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="right_name" class="col-md-4 col-form-label text-md-right">{{ __('Right Name') }}</label>

                        <div class="col-md-6">
                            <input id="right_name" type="text" class="form-control" name="right_name"
                                value="{{ $right->right_name }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="right_value" class="col-md-4 col-form-label text-md-right">{{ __('Right Value') }}</label>

                        <div class="col-md-6">
                            <input id="right_value" type="text" class="form-control" name="right_value"
                                value="{{ $right->right_value }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="right_path" class="col-md-4 col-form-label text-md-right">{{ __('Right Path') }}</label>

                        <div class="col-md-6">
                            <input id="right_path" type="text" class="form-control" name="right_path"
                                value="{{ $right->right_path }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="/right/{{ $right->id }}/edit" class="btn btn-primary">
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
