<div class="form-group row">
    <label for="role_name" class="col-md-4 col-form-label text-md-right">{{ __('Role Name') }}</label>
    <div class="col-md-6">
        <input id="role_name" type="text" class="form-control @error('role_name') is-invalid @enderror" name="role_name"
            value="{{ old('role_name') ?? $role->role_name }}" required autocomplete="role_name" autofocus>
        @error('role_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="role_description" class="col-md-4 col-form-label text-md-right">{{ __('Role Description') }}</label>
    <div class="col-md-6">
        <input id="role_description" type="text" class="form-control @error('role_description') is-invalid @enderror"
            name="role_description" value="{{ old('role_description') ?? $role->role_description }}" required
            autocomplete="role_description" autofocus>
        @error('role_description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>