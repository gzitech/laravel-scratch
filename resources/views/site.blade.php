@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="nav mr-auto">
                    </div>
                    <div class="nav ml-auto">
                        @right('site.edit')
                        <a href="/site/create" role="button" class="btn btn-primary btn-sm">Create</a>
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
                            @foreach ($sites as $site)
                            <tr>
                                <th scope="row">{{ $site->id }}</th>
                                <td><a
                                        href="//{{ $site->name }}.{{ Config::get('site.default_domain') }}">{{ $site->name }}</a>
                                </td>
                                <td class="text-md-right">
                                    <a href="/site/{{ $site->id }}" title="Show" class="btn btn-outline-primary"><i
                                            class="fa fa-user-o"></i></a>
                                    @right('site.edit')
                                    <a href="/site/{{ $site->id }}/destroy" title="Destroy"
                                        class="btn btn-outline-danger"><i class="fa fa-trash-o"></i></a>
                                    @endright
                                </td>
                            </tr>
                            @endforeach
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
        </div>
    </div>
</div>
@endsection