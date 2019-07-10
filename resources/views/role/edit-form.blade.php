<div class="form-group row">
    <label for="id" class="col-md-4 col-form-label text-md-right">{{ __('Id') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="id" type="text" class="form-control" name="id" v-model="roleEditForm.id"
            :class="{'is-invalid': roleEditForm.errors.has('id')}" required autocomplete="id" autofocus>
        <span class="invalid-feedback" role="alert" v-show="roleEditForm.errors.has('id')">
            <strong>@{{ roleEditForm.errors.get('id') }}</strong>
        </span>
        @vuelse
        <input id="id" type="text" class="form-control @error('id') is-invalid @enderror"
            name="id" value="{{ old('id') ?? $role->id }}" required autocomplete="id"
            autofocus>
        @error('id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>
<div class="form-group row">
    <label for="role_name" class="col-md-4 col-form-label text-md-right">{{ __('Role Name') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="role_name" type="text" class="form-control" name="role_name" v-model="roleEditForm.role_name"
            :class="{'is-invalid': roleEditForm.errors.has('role_name')}" required autocomplete="role_name" autofocus>
        <span class="invalid-feedback" role="alert" v-show="roleEditForm.errors.has('role_name')">
            <strong>@{{ roleEditForm.errors.get('role_name') }}</strong>
        </span>
        @vuelse
        <input id="role_name" type="text" class="form-control @error('role_name') is-invalid @enderror"
            name="role_name" value="{{ old('role_name') ?? $role->role_name }}" required autocomplete="role_name"
            autofocus>
        @error('role_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>
<div class="form-group row">
    <label for="role_description" class="col-md-4 col-form-label text-md-right">{{ __('Role Description') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="role_description" type="text" class="form-control" name="role_description" v-model="roleEditForm.role_description"
            :class="{'is-invalid': roleEditForm.errors.has('role_description')}" required autocomplete="role_description" autofocus>
        <span class="invalid-feedback" role="alert" v-show="roleEditForm.errors.has('role_description')">
            <strong>@{{ roleEditForm.errors.get('role_description') }}</strong>
        </span>
        @vuelse
        <input id="role_description" type="text" class="form-control @error('role_description') is-invalid @enderror"
            name="role_description" value="{{ old('role_description') ?? $role->role_description }}" required autocomplete="role_description"
            autofocus>
        @error('role_description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>
<div class="form-group row">
    <label for="right" class="col-md-4 col-form-label text-md-right">{{ __('Right') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="right" type="text" class="form-control" name="right" v-model="roleEditForm.right"
            :class="{'is-invalid': roleEditForm.errors.has('right')}" required autocomplete="right" autofocus>
        <span class="invalid-feedback" role="alert" v-show="roleEditForm.errors.has('right')">
            <strong>@{{ roleEditForm.errors.get('right') }}</strong>
        </span>
        @vuelse
        <input id="right" type="text" class="form-control @error('right') is-invalid @enderror"
            name="right" value="{{ old('right') ?? $role->right }}" required autocomplete="right"
            autofocus>
        @error('right')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>
<div class="form-group row">
    <label for="deleted_at" class="col-md-4 col-form-label text-md-right">{{ __('Deleted At') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="deleted_at" type="text" class="form-control" name="deleted_at" v-model="roleEditForm.deleted_at"
            :class="{'is-invalid': roleEditForm.errors.has('deleted_at')}" required autocomplete="deleted_at" autofocus>
        <span class="invalid-feedback" role="alert" v-show="roleEditForm.errors.has('deleted_at')">
            <strong>@{{ roleEditForm.errors.get('deleted_at') }}</strong>
        </span>
        @vuelse
        <input id="deleted_at" type="text" class="form-control @error('deleted_at') is-invalid @enderror"
            name="deleted_at" value="{{ old('deleted_at') ?? $role->deleted_at }}" required autocomplete="deleted_at"
            autofocus>
        @error('deleted_at')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>
<div class="form-group row">
    <label for="created_at" class="col-md-4 col-form-label text-md-right">{{ __('Created At') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="created_at" type="text" class="form-control" name="created_at" v-model="roleEditForm.created_at"
            :class="{'is-invalid': roleEditForm.errors.has('created_at')}" required autocomplete="created_at" autofocus>
        <span class="invalid-feedback" role="alert" v-show="roleEditForm.errors.has('created_at')">
            <strong>@{{ roleEditForm.errors.get('created_at') }}</strong>
        </span>
        @vuelse
        <input id="created_at" type="text" class="form-control @error('created_at') is-invalid @enderror"
            name="created_at" value="{{ old('created_at') ?? $role->created_at }}" required autocomplete="created_at"
            autofocus>
        @error('created_at')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>
<div class="form-group row">
    <label for="updated_at" class="col-md-4 col-form-label text-md-right">{{ __('Updated At') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="updated_at" type="text" class="form-control" name="updated_at" v-model="roleEditForm.updated_at"
            :class="{'is-invalid': roleEditForm.errors.has('updated_at')}" required autocomplete="updated_at" autofocus>
        <span class="invalid-feedback" role="alert" v-show="roleEditForm.errors.has('updated_at')">
            <strong>@{{ roleEditForm.errors.get('updated_at') }}</strong>
        </span>
        @vuelse
        <input id="updated_at" type="text" class="form-control @error('updated_at') is-invalid @enderror"
            name="updated_at" value="{{ old('updated_at') ?? $role->updated_at }}" required autocomplete="updated_at"
            autofocus>
        @error('updated_at')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>