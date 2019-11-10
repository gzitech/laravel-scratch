<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'scratch') }}</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'
        type='text/css'>
    @stack('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="ssky-app">
        @none
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'scratch') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Navigation -->
                        @if (Auth::check())
                        @include('nav.user')
                        @else
                        @include('nav.guest')
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
        @endnone
    </div>
    @none
    <div class="modal" tabindex="-1" role="dialog" id="destroy-confirm">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="#destroy">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <strong>{{ __("Are you sure?") }}</strong>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label id="destroy-confirm-key" class="col-md-4 col-form-label text-md-right"></label>
                            <div class="col-md-6">
                                <div id="destroy-confirm-value" class="form-control"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/none.js') }}"></script>
    @elsenone
    <script src="{{ mix('js/app.js') }}"></script>
    @endnone
    @stack('scripts')
</body>

</html>