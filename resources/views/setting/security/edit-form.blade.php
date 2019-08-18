<div class="form-group row">
    <label for="current_password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>
    <div class="col-md-6">
        <input id="current_password" type="text" class="form-control @error('current_password') is-invalid @enderror"
            name="current_password" value="{{ old('current_password') }}" required autocomplete="current_password"
            autofocus>
        @error('current_password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
    <div class="col-md-6">
        <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password"
            value="{{ old('password') }}" required autocomplete="password" autofocus>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="password_confirmation"
        class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
    <div class="col-md-6">
        <input id="password_confirmation" type="text"
            class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"
            value="{{ old('password_confirmation') ?? $user->password_confirmation }}" required
            autocomplete="password_confirmation" autofocus>
        @error('password_confirmation')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>