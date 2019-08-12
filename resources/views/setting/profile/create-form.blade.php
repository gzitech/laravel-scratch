<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="name" type="text" class="form-control" name="name" v-model="settingProfileCreateForm.name"
            :class="{'is-invalid': settingProfileCreateForm.errors.has('name')}" required autocomplete="name"
            autofocus>
        <span class="invalid-feedback" role="alert" v-show="settingProfileCreateForm.errors.has('name')">
            <strong>@{{ settingProfileCreateForm.errors.get('name') }}</strong>
        </span>
        @vuelse
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
            value="{{ old('name') }}" required autocomplete="name" autofocus>
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
        <input id="description" type="text" class="form-control" name="description" v-model="settingProfileCreateForm.description"
            :class="{'is-invalid': settingProfileCreateForm.errors.has('description')}" required autocomplete="description"
            autofocus>
        <span class="invalid-feedback" role="alert" v-show="settingProfileCreateForm.errors.has('description')">
            <strong>@{{ settingProfileCreateForm.errors.get('description') }}</strong>
        </span>
        @vuelse
        <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description"
            value="{{ old('description') }}" required autocomplete="description" autofocus>
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>