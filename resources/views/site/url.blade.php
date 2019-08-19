@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        @vueif
        <ssky-site-url-list inline-template :paginate="{{ $siteUrls->toJson() }}">
            @vuend
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="nav mr-auto">

                        </div>
                        <div class="nav ml-auto">
                            <a href="/site/url/create" role="button" class="btn btn-primary btn-sm" @vueif
                                @click.prevent="showSiteUrlCreateForm" @vuend>Create</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Site Id</th>
                                    <th scope="col">Domain</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @vueif
                                <tr v-for="siteUrl in siteUrls" :key="siteUrl.id">
                                    <th scope="row">@{{ siteUrl.id }}</th>
                                    <td>@{{ siteUrl.site_id }}</td>
                                    <td>@{{ siteUrl.domain }}</td>
                                    <td class="text-md-right">
                                        <a :href="showUrl(siteUrl.id)" title="Show"
                                            class="btn btn-outline-primary"><i
                                                class="fa fa-user-o"></i></a>
                                        <a href="#edit" title="Edit" class="btn btn-outline-primary"
                                            @click.prevent="showSiteUrlEditForm(siteUrl)"><i
                                                class="fa fa-pencil"></i></a>
                                        <a href="#del" title="Destroy" class="btn btn-outline-danger"
                                            @click.prevent="showSiteUrlDestroyConfirm(siteUrl)"><i
                                                class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                @vuend
                                @noneif
                                @foreach ($siteUrls as $siteUrl)
                                <tr>
                                    <th scope="row">{{ $siteUrl->id }}</th>
                                    <td>{{ $siteUrl->site_id }}</td>
                                    <td>{{ $siteUrl->domain }}</td>
                                    <td class="text-md-right">
                                        <a href="/site/url/{{ $siteUrl->id }}" title="Show"
                                            class="btn btn-outline-primary"><i
                                                class="fa fa-user-o"></i></a>
                                        <a href="/site/url/{{ $siteUrl->id }}/edit" title="Edit"
                                            class="btn btn-outline-primary"><i class="fa fa-pencil"></i></a>
                                        <a href="/site/url/{{ $siteUrl->id }}/destroy"
                                            title="Destroy" class="btn btn-outline-danger"><i
                                                class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @nonend
                            </tbody>
                        </table>
                    </div>
                    @if($siteUrls->previousPageUrl() || $siteUrls->nextPageUrl())
                    <div class="card-footer d-flex">
                        <div class="nav mr-auto">

                        </div>
                        <div class="nav ml-auto">
                            {{ $siteUrls->links() }}
                        </div>
                    </div>
                    @endif
                </div>
                @vueif
                <ssky-site-url-create inline-template :old="{}" :errors="{}">
                    <div class="modal" tabindex="-1" role="dialog" id="site-url-create-form">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST" action="/site/url"
                                    @submit="validateSiteUrlCreateForm">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            {{ __('Create') }}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @include('site/url.create-form')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"
                                            :disabled="siteUrlCreateForm.busy">{{ __('Save') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </ssky-site-url-create>
                <ssky-site-url-edit inline-template :site_url="siteUrl" :old="{}"
                    :errors="{}" @site-url-updated="updatedSiteUrl">
                    <div class="modal" tabindex="-1" role="dialog" id="site-url-edit-form">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST" action="#update" @submit="validateSiteUrlEditForm">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            {{ __('Edit') }}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @include('site/url.edit-form')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"
                                            :disabled="siteUrlEditForm.busy">{{ __('Update') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </ssky-site-url-edit>
                <div class="modal" tabindex="-1" role="dialog" id="site-url-destroy-confirm">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST" action="#destroy">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <strong>{{ __("Are you sure delete this siteUrl?") }}</strong>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('Site Id') }}</label>
                                        <div class="col-md-6">
                                            <div class="form-control">@{{siteUrl.site_id}}</div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('Domain') }}</label>
                                        <div class="col-md-6">
                                            <div class="form-control">@{{siteUrl.domain}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">{{ __('Delete') }}</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @vuend
            </div>
            @vueif
        </ssky-site-url-list>
        @vuend
    </div>
</div>
@endsection