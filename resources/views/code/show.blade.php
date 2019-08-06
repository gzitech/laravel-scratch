@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/code/">Code</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $model->model_name }}</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="model_name"
                            class="col-md-4 col-form-label text-md-right">{{ __('Model Name') }}</label>

                        <div class="col-md-6">
                            <input id="model_name" type="text" class="form-control" name="model_name"
                                value="{{ $model->model_name }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex">
                    <div class="nav mr-auto">

                    </div>
                    <div class="nav ml-auto">
                        <a href="/code/create" role="button" class="btn btn-primary btn-sm" @vueif
                            @click.prevent="showCodeCreateForm" @vuend>{{ __('Generate Code')}}</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input type="checkbox">
                                </th>
                                <th scope="col">Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">Control</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($model->columns as $col)
                            <tr>
                                <th scope="row">
                                    <input type="checkbox" name="column">
                                </th>
                                <td>{{ $col }}</td>
                                <td>{{ $col }}</td>
                                <td>{{ $col }}</td>
                                <td class="text-md-right">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection