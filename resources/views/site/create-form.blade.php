<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Site Name') }}</label>
    <div class="col-md-6">
        <div class="input-group">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" required autocomplete="name" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">.{{ config('site.default_domain') }}</div>
            </div>
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>