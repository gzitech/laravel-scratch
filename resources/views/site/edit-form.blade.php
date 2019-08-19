<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="name" type="text" class="form-control" name="name" v-model="siteEditForm.name"
            :class="{'is-invalid': siteEditForm.errors.has('name')}" required autocomplete="name" autofocus>
        <span class="invalid-feedback" role="alert" v-show="siteEditForm.errors.has('name')">
            <strong>@{{ siteEditForm.errors.get('name') }}</strong>
        </span>
        @vuelse
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
            name="name" value="{{ old('name') ?? $site->name }}" required autocomplete="name"
            autofocus>
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>