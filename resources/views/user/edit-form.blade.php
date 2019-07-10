<div class="form-group row">
    <label for="id" class="col-md-4 col-form-label text-md-right">{{ __('Id') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="id" type="text" class="form-control" name="id" v-model="userEditForm.id"
            :class="{'is-invalid': userEditForm.errors.has('id')}" required autocomplete="id" autofocus>
        <span class="invalid-feedback" role="alert" v-show="userEditForm.errors.has('id')">
            <strong>@{{ userEditForm.errors.get('id') }}</strong>
        </span>
        @vuelse
        <input id="id" type="text" class="form-control @error('id') is-invalid @enderror"
            name="id" value="{{ old('id') ?? $user->id }}" required autocomplete="id"
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
    <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="first_name" type="text" class="form-control" name="first_name" v-model="userEditForm.first_name"
            :class="{'is-invalid': userEditForm.errors.has('first_name')}" required autocomplete="first_name" autofocus>
        <span class="invalid-feedback" role="alert" v-show="userEditForm.errors.has('first_name')">
            <strong>@{{ userEditForm.errors.get('first_name') }}</strong>
        </span>
        @vuelse
        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
            name="first_name" value="{{ old('first_name') ?? $user->first_name }}" required autocomplete="first_name"
            autofocus>
        @error('first_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>
<div class="form-group row">
    <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="last_name" type="text" class="form-control" name="last_name" v-model="userEditForm.last_name"
            :class="{'is-invalid': userEditForm.errors.has('last_name')}" required autocomplete="last_name" autofocus>
        <span class="invalid-feedback" role="alert" v-show="userEditForm.errors.has('last_name')">
            <strong>@{{ userEditForm.errors.get('last_name') }}</strong>
        </span>
        @vuelse
        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
            name="last_name" value="{{ old('last_name') ?? $user->last_name }}" required autocomplete="last_name"
            autofocus>
        @error('last_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>
<div class="form-group row">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="email" type="text" class="form-control" name="email" v-model="userEditForm.email"
            :class="{'is-invalid': userEditForm.errors.has('email')}" required autocomplete="email" autofocus>
        <span class="invalid-feedback" role="alert" v-show="userEditForm.errors.has('email')">
            <strong>@{{ userEditForm.errors.get('email') }}</strong>
        </span>
        @vuelse
        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
            name="email" value="{{ old('email') ?? $user->email }}" required autocomplete="email"
            autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>
<div class="form-group row">
    <label for="email_verified_at" class="col-md-4 col-form-label text-md-right">{{ __('Email Verified At') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="email_verified_at" type="text" class="form-control" name="email_verified_at" v-model="userEditForm.email_verified_at"
            :class="{'is-invalid': userEditForm.errors.has('email_verified_at')}" required autocomplete="email_verified_at" autofocus>
        <span class="invalid-feedback" role="alert" v-show="userEditForm.errors.has('email_verified_at')">
            <strong>@{{ userEditForm.errors.get('email_verified_at') }}</strong>
        </span>
        @vuelse
        <input id="email_verified_at" type="text" class="form-control @error('email_verified_at') is-invalid @enderror"
            name="email_verified_at" value="{{ old('email_verified_at') ?? $user->email_verified_at }}" required autocomplete="email_verified_at"
            autofocus>
        @error('email_verified_at')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>
<div class="form-group row">
    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="password" type="text" class="form-control" name="password" v-model="userEditForm.password"
            :class="{'is-invalid': userEditForm.errors.has('password')}" required autocomplete="password" autofocus>
        <span class="invalid-feedback" role="alert" v-show="userEditForm.errors.has('password')">
            <strong>@{{ userEditForm.errors.get('password') }}</strong>
        </span>
        @vuelse
        <input id="password" type="text" class="form-control @error('password') is-invalid @enderror"
            name="password" value="{{ old('password') ?? $user->password }}" required autocomplete="password"
            autofocus>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>
<div class="form-group row">
    <label for="remember_token" class="col-md-4 col-form-label text-md-right">{{ __('Remember Token') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="remember_token" type="text" class="form-control" name="remember_token" v-model="userEditForm.remember_token"
            :class="{'is-invalid': userEditForm.errors.has('remember_token')}" required autocomplete="remember_token" autofocus>
        <span class="invalid-feedback" role="alert" v-show="userEditForm.errors.has('remember_token')">
            <strong>@{{ userEditForm.errors.get('remember_token') }}</strong>
        </span>
        @vuelse
        <input id="remember_token" type="text" class="form-control @error('remember_token') is-invalid @enderror"
            name="remember_token" value="{{ old('remember_token') ?? $user->remember_token }}" required autocomplete="remember_token"
            autofocus>
        @error('remember_token')
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
        <input id="right" type="text" class="form-control" name="right" v-model="userEditForm.right"
            :class="{'is-invalid': userEditForm.errors.has('right')}" required autocomplete="right" autofocus>
        <span class="invalid-feedback" role="alert" v-show="userEditForm.errors.has('right')">
            <strong>@{{ userEditForm.errors.get('right') }}</strong>
        </span>
        @vuelse
        <input id="right" type="text" class="form-control @error('right') is-invalid @enderror"
            name="right" value="{{ old('right') ?? $user->right }}" required autocomplete="right"
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
        <input id="deleted_at" type="text" class="form-control" name="deleted_at" v-model="userEditForm.deleted_at"
            :class="{'is-invalid': userEditForm.errors.has('deleted_at')}" required autocomplete="deleted_at" autofocus>
        <span class="invalid-feedback" role="alert" v-show="userEditForm.errors.has('deleted_at')">
            <strong>@{{ userEditForm.errors.get('deleted_at') }}</strong>
        </span>
        @vuelse
        <input id="deleted_at" type="text" class="form-control @error('deleted_at') is-invalid @enderror"
            name="deleted_at" value="{{ old('deleted_at') ?? $user->deleted_at }}" required autocomplete="deleted_at"
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
        <input id="created_at" type="text" class="form-control" name="created_at" v-model="userEditForm.created_at"
            :class="{'is-invalid': userEditForm.errors.has('created_at')}" required autocomplete="created_at" autofocus>
        <span class="invalid-feedback" role="alert" v-show="userEditForm.errors.has('created_at')">
            <strong>@{{ userEditForm.errors.get('created_at') }}</strong>
        </span>
        @vuelse
        <input id="created_at" type="text" class="form-control @error('created_at') is-invalid @enderror"
            name="created_at" value="{{ old('created_at') ?? $user->created_at }}" required autocomplete="created_at"
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
        <input id="updated_at" type="text" class="form-control" name="updated_at" v-model="userEditForm.updated_at"
            :class="{'is-invalid': userEditForm.errors.has('updated_at')}" required autocomplete="updated_at" autofocus>
        <span class="invalid-feedback" role="alert" v-show="userEditForm.errors.has('updated_at')">
            <strong>@{{ userEditForm.errors.get('updated_at') }}</strong>
        </span>
        @vuelse
        <input id="updated_at" type="text" class="form-control @error('updated_at') is-invalid @enderror"
            name="updated_at" value="{{ old('updated_at') ?? $user->updated_at }}" required autocomplete="updated_at"
            autofocus>
        @error('updated_at')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>