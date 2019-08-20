@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        @vue
        <ssky-site-list inline-template :paginate="{{ $sites->toJson() }}">
            @endvue
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="nav mr-auto">

                        </div>
                        <div class="nav ml-auto">
                            @right('site.update')
                            <a href="/site/create" role="button" class="btn btn-primary btn-sm" @vue
                                @click.prevent="showSiteCreateForm" @endvue>Create</a>
                            @endright
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Site Name</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @vue
                                <tr v-for="site in sites" :key="site.id">
                                    <th scope="row">@{{ site.id }}</th>
                                    <td><a :href="siteUrl(site, '{{ Config::get('site.default_domain') }}')">@{{ site.name }}</a></td>
                                    <td class="text-md-right">
                                        <a :href="showUrl(site.id)" title="Show" class="btn btn-outline-primary"><i
                                                class="fa fa-user-o"></i></a>
                                        @right('site.update')
                                        <a href="#del" title="Destroy" class="btn btn-outline-danger"
                                            @click.prevent="showSiteDestroyConfirm(site)"><i
                                                class="fa fa-trash-o"></i></a>
                                        @endright
                                    </td>
                                </tr>
                                @endvue
                                @none
                                @foreach ($sites as $site)
                                <tr>
                                    <th scope="row">{{ $site->id }}</th>
                                    <td><a href="//{{ $site->name }}.{{ Config::get('site.default_domain') }}">{{ $site->name }}</a></td>
                                    <td class="text-md-right">
                                        <a href="/site/{{ $site->id }}" title="Show" class="btn btn-outline-primary"><i
                                                class="fa fa-user-o"></i></a>
                                        @right('site.update')
                                        <a href="/site/{{ $site->id }}/destroy" title="Destroy"
                                            class="btn btn-outline-danger"><i class="fa fa-trash-o"></i></a>
                                        @endright
                                    </td>
                                </tr>
                                @endforeach
                                @endnone
                            </tbody>
                        </table>
                    </div>
                    @if($sites->previousPageUrl() || $sites->nextPageUrl())
                    <div class="card-footer d-flex">
                        <div class="nav mr-auto">

                        </div>
                        <div class="nav ml-auto">
                            {{ $sites->links() }}
                        </div>
                    </div>
                    @endif
                </div>
                @right('site.update')
                @vue
                <ssky-site-create inline-template :old="{}" :errors="{}">
                    <div class="modal" tabindex="-1" role="dialog" id="site-create-form">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST" action="/site" @submit="validateSiteCreateForm">
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
                                        @include('site.create-form')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"
                                            :disabled="siteCreateForm.busy">{{ __('Save') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </ssky-site-create>
                <div class="modal" tabindex="-1" role="dialog" id="site-destroy-confirm">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST" action="#destroy">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <strong>{{ __("Are you sure delete this site?") }}</strong>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                        <div class="col-md-6">
                                            <div class="form-control">@{{site.name}}</div>
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
                @endvue
                @endright
            </div>
            @vue
        </ssky-site-list>
        @endvue
    </div>
</div>
@endsection