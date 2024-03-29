@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/role/">Role</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $role->role_name }}</li>
                </ol>
            </nav>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card">
                <form method="POST" action="/role/right/{{ $role->id }}" submit="validateRightCreateForm">
                    @csrf
                    <div class="card-header d-flex">
                        <div class="nav mr-auto">

                        </div>
                        <div class="nav ml-auto">
                        @right('right.edit')<button type="submit" class="btn btn-primary btn-sm">{{ __('Update')}}</button>@endright
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Value</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rights as $right)
                                @right($right->name)
                                <tr>
                                    <th scope="row">
                                        <input type="checkbox" name="right[]" value="{{ $right->value }}" {{ ($role->right & $right->value) ? "checked" : "" }}>
                                    </th>
                                    <td>{{ $right->name }}</td>
                                    <td>{{ $right->value }}</td>
                                    <td>{{ __("right." . $right->name) }}</td>
                                    <td class="text-md-right"></td>
                                </tr>
                                @endright
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
