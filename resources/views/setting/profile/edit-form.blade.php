<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="name" type="text" class="form-control" name="name" v-model="settingProfileEditForm.name"
            :class="{'is-invalid': settingProfileEditForm.errors.has('name')}" required autocomplete="name" autofocus>
        <span class="invalid-feedback" role="alert" v-show="settingProfileEditForm.errors.has('name')">
            <strong>@{{ settingProfileEditForm.errors.get('name') }}</strong>
        </span>
        @vuelse
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
            name="name" value="{{ old('name') ?? $settingProfile->name }}" required autocomplete="name"
            autofocus>
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>
<div class="form-group row">
    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="description" type="text" class="form-control" name="description" v-model="settingProfileEditForm.description"
            :class="{'is-invalid': settingProfileEditForm.errors.has('description')}" required autocomplete="description" autofocus>
        <span class="invalid-feedback" role="alert" v-show="settingProfileEditForm.errors.has('description')">
            <strong>@{{ settingProfileEditForm.errors.get('description') }}</strong>
        </span>
        @vuelse
        <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
            name="description" value="{{ old('description') ?? $settingProfile->description }}" required autocomplete="description"
            autofocus>
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>