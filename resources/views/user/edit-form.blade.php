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
        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name"
            value="{{ old('last_name') ?? $user->last_name }}" required autocomplete="last_name" autofocus>
        @error('last_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>

<div class="form-group row">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="email" type="email" class="form-control" name="email" v-model="userEditForm.email"
            :class="{'is-invalid': userEditForm.errors.has('email')}" disabled required autocomplete="email">
        <span class="invalid-feedback" role="alert" v-show="userEditForm.errors.has('email')">
            <strong>@{{ userEditForm.errors.get('email') }}</strong>
        </span>
        @vuelse
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ old('email') ?? $user->email }}" disabled required autocomplete="email">
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>