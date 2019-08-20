<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Site Name') }}</label>

    <div class="col-md-6">
        @vueif
        <div class="input-group">
            <input id="name" type="text" class="form-control" name="name" v-model="siteCreateForm.name"
                :class="{'is-invalid': siteCreateForm.errors.has('name')}" required autocomplete="name" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">.{{ Config::get('site.default_domain') }}</div>
            </div>
        </div>
        <span class="invalid-feedback" role="alert" v-show="siteCreateForm.errors.has('name')">
            <strong>@{{ siteCreateForm.errors.get('name') }}</strong>
        </span>
        @vuelse
        <div class="input-group">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" required autocomplete="name" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">.{{ Config::get('site.default_domain') }}</div>
            </div>
        </div>
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>