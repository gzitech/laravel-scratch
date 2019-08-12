@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/setting/profile/">SettingProfile</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-body">
                    @vueif<ssky-setting-profile-edit inline-template :setting_profile="{{ $settingProfile->toJson() }}" :old="{{ json_encode(Session::getOldInput()) }}"
                    :errors="{{ $errors }}">@vuend
                    <form method="POST" action="/setting/profile/{{$settingProfile->id}}">
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
                    @vueif</ssky-setting-profile-edit>@vuend
                </div>
            </div>
        </div>
    </div>
</div>
@endsection