<div class="form-group row">
    <label for="model_name" class="col-md-4 col-form-label text-md-right">{{ __('Model Name') }}</label>

    <div class="col-md-6">
        @vueif
        <input id="model_name" type="text" class="form-control" name="model_name" v-model="codeCreateForm.model_name"
            :class="{'is-invalid': codeCreateForm.errors.has('model_name')}" required autocomplete="model_name"
            autofocus>
        <span class="invalid-feedback" role="alert" v-show="codeCreateForm.errors.has('model_name')">
            <strong>@{{ codeCreateForm.errors.get('model_name') }}</strong>
        </span>
        @vuelse
        <input id="model_name" type="text" class="form-control @error('model_name') is-invalid @enderror" name="model_name"
            value="{{ old('model_name') }}" required autocomplete="model_name" autofocus>
        @error('model_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        @vuend
    </div>
</div>