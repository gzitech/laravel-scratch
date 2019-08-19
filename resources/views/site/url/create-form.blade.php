<div class="form-group row">
    <label for="site_id" class="col-md-4 col-form-label text-md-right">{{ __('Site Id') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="site_id" type="text" class="form-control" name="site_id" v-model="siteUrlCreateForm.site_id"
            :class="{'is-invalid': siteUrlCreateForm.errors.has('site_id')}" required autocomplete="site_id"
            autofocus>
        <span class="invalid-feedback" role="alert" v-show="siteUrlCreateForm.errors.has('site_id')">
            <strong>@{{ siteUrlCreateForm.errors.get('site_id') }}</strong>
        </span>
        @vuelse
        <input id="site_id" type="text" class="form-control @error('site_id') is-invalid @enderror" name="site_id"
            value="{{ old('site_id') }}" required autocomplete="site_id" autofocus>
        @error('site_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>
<div class="form-group row">
    <label for="domain" class="col-md-4 col-form-label text-md-right">{{ __('Domain') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="domain" type="text" class="form-control" name="domain" v-model="siteUrlCreateForm.domain"
            :class="{'is-invalid': siteUrlCreateForm.errors.has('domain')}" required autocomplete="domain"
            autofocus>
        <span class="invalid-feedback" role="alert" v-show="siteUrlCreateForm.errors.has('domain')">
            <strong>@{{ siteUrlCreateForm.errors.get('domain') }}</strong>
        </span>
        @vuelse
        <input id="domain" type="text" class="form-control @error('domain') is-invalid @enderror" name="domain"
            value="{{ old('domain') }}" required autocomplete="domain" autofocus>
        @error('domain')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>