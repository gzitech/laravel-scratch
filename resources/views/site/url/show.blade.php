@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        <div class="col-md-10">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/site/url/">SiteUrl</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="site_id" class="col-md-4 col-form-label text-md-right">{{ __('Site Id') }}</label>

                        <div class="col-md-6">
                            <input id="site_id" type="text" class="form-control" name="site_id"
                                value="{{ $siteUrl->site_id }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="domain" class="col-md-4 col-form-label text-md-right">{{ __('Domain') }}</label>

                        <div class="col-md-6">
                            <input id="domain" type="text" class="form-control" name="domain"
                                value="{{ $siteUrl->domain }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="/site/url/{{ $siteUrl->id }}/edit" class="btn btn-primary">
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