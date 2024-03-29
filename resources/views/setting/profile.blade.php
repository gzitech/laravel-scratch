@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.setting')
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Contact Information</div>
                <div class="card-body">
                    <form method="POST" action="/setting/profile/{{$user->id}}">
                        @csrf
                        @method('PUT')
                        @include('setting/profile.edit-form')
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection