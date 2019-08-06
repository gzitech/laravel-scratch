<div class="form-group row">
    <label for="right_name" class="col-md-4 col-form-label text-md-right">{{ __('Right Name') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="right_name" type="text" class="form-control" name="right_name" v-model="rightCreateForm.right_name"
            :class="{'is-invalid': rightCreateForm.errors.has('right_name')}" required autocomplete="right_name"
            autofocus>
        <span class="invalid-feedback" role="alert" v-show="rightCreateForm.errors.has('right_name')">
            <strong>@{{ rightCreateForm.errors.get('right_name') }}</strong>
        </span>
        @vuelse
        <input id="right_name" type="text" class="form-control @error('right_name') is-invalid @enderror" name="right_name"
            value="{{ old('right_name') }}" required autocomplete="right_name" autofocus>
        @error('right_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>

<div class="form-group row">
    <label for="right_value" class="col-md-4 col-form-label text-md-right">{{ __('Right Value') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="right_value" type="text" class="form-control" name="right_value" v-model="rightCreateForm.right_value"
            :class="{'is-invalid': rightCreateForm.errors.has('right_value')}" required autocomplete="right_value"
            autofocus>
        <span class="invalid-feedback" role="alert" v-show="rightCreateForm.errors.has('right_value')">
            <strong>@{{ rightCreateForm.errors.get('right_value') }}</strong>
        </span>
        @vuelse
        <input id="right_value" type="text" class="form-control @error('right_value') is-invalid @enderror" name="right_value"
            value="{{ old('right_value') }}" required autocomplete="right_value" autofocus>
        @error('right_value')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>

<div class="form-group row">
    <label for="right_path" class="col-md-4 col-form-label text-md-right">{{ __('Right Path') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="right_path" type="text" class="form-control" name="right_path" v-model="rightCreateForm.right_path"
            :class="{'is-invalid': rightCreateForm.errors.has('right_path')}" required autocomplete="right_path"
            autofocus>
        <span class="invalid-feedback" role="alert" v-show="rightCreateForm.errors.has('right_path')">
            <strong>@{{ rightCreateForm.errors.get('right_path') }}</strong>
        </span>
        @vuelse
        <input id="right_path" type="text" class="form-control @error('right_path') is-invalid @enderror" name="right_path"
            value="{{ old('right_path') }}" required autocomplete="right_path" autofocus>
        @error('right_path')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>