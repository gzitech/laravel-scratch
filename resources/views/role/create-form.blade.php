<div class="form-group row">
    <label for="role_name" class="col-md-4 col-form-label text-md-right">{{ __('Role Name') }}</label>

    <div class="col-md-6">
        @vue
        <input id="role_name" type="text" class="form-control" name="role_name" v-model="roleCreateForm.role_name"
            :class="{'is-invalid': roleCreateForm.errors.has('role_name')}" required autocomplete="role_name"
            autofocus>
        <span class="invalid-feedback" role="alert" v-show="roleCreateForm.errors.has('role_name')">
            <strong>@{{ roleCreateForm.errors.get('role_name') }}</strong>
        </span>
        @endvue
        @none
        <input id="role_name" type="text" class="form-control @error('role_name') is-invalid @enderror" name="role_name"
            value="{{ old('role_name') }}" required autocomplete="role_name" autofocus>
        @error('role_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @endnone
    </div>
</div>

<div class="form-group row">
    <label for="role_description" class="col-md-4 col-form-label text-md-right">{{ __('Role Description') }}</label>

    <div class="col-md-6">
        @vue
        <input id="role_description" type="text" class="form-control" name="role_description" v-model="roleCreateForm.role_description"
            :class="{'is-invalid': roleCreateForm.errors.has('role_description')}" required autocomplete="role_description"
            autofocus>
        <span class="invalid-feedback" role="alert" v-show="roleCreateForm.errors.has('role_description')">
            <strong>@{{ roleCreateForm.errors.get('role_description') }}</strong>
        </span>
        @endvue
        @none
        <input id="role_description" type="text" class="form-control @error('role_description') is-invalid @enderror" name="role_description"
            value="{{ old('role_description') }}" required autocomplete="role_description" autofocus>
        @error('role_description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @endnone
    </div>
</div>