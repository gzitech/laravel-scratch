@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.setting')
        @vueif
        <ssky-setting-profile-list inline-template :paginate="{{ $settingProfiles->toJson() }}">
            @vuend
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="nav mr-auto">

                        </div>
                        <div class="nav ml-auto">
                            <a href="/setting/profile/create" role="button" class="btn btn-primary btn-sm" @vueif
                                @click.prevent="showSettingProfileCreateForm" @vuend>Create</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @vueif
                                <tr v-for="settingProfile in settingProfiles" :key="settingProfile.id">
                                    <th scope="row">@{{ settingProfile.id }}</th>
                                    <td>@{{ settingProfile.name }}</td>
                                    <td>@{{ settingProfile.description }}</td>
                                    <td class="text-md-right">
                                        <a :href="showUrl(settingProfile.id)" title="Show"
                                            class="btn btn-outline-primary"><i
                                                class="fa fa-user-o"></i></a>
                                        <a href="#edit" title="Edit" class="btn btn-outline-primary"
                                            @click.prevent="showSettingProfileEditForm(settingProfile)"><i
                                                class="fa fa-pencil"></i></a>
                                        <a href="#del" title="Destroy" class="btn btn-outline-danger"
                                            @click.prevent="showSettingProfileDestroyConfirm(settingProfile)"><i
                                                class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                @vuend
                                @noneif
                                @foreach ($settingProfiles as $settingProfile)
                                <tr>
                                    <th scope="row">{{ $settingProfile->id }}</th>
                                    <td>{{ $settingProfile->name }}</td>
                                    <td>{{ $settingProfile->description }}</td>
                                    <td class="text-md-right">
                                        <a href="/setting/profile/{{ $settingProfile->id }}" title="Show"
                                            class="btn btn-outline-primary"><i
                                                class="fa fa-user-o"></i></a>
                                        <a href="/setting/profile/{{ $settingProfile->id }}/edit" title="Edit"
                                            class="btn btn-outline-primary"><i class="fa fa-pencil"></i></a>
                                        <a href="/setting/profile/{{ $settingProfile->id }}/destroy"
                                            title="Destroy" class="btn btn-outline-danger"><i
                                                class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @nonend
                            </tbody>
                        </table>
                    </div>
                    @if($settingProfiles->previousPageUrl() || $settingProfiles->nextPageUrl())
                    <div class="card-footer d-flex">
                        <div class="nav mr-auto">

                        </div>
                        <div class="nav ml-auto">
                            {{ $settingProfiles->links() }}
                        </div>
                    </div>
                    @endif
                </div>
                @vueif
                <ssky-setting-profile-create inline-template :old="{}" :errors="{}">
                    <div class="modal" tabindex="-1" role="dialog" id="setting-profile-create-form">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST" action="/setting/profile"
                                    @submit="validateSettingProfileCreateForm">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            {{ __('Create') }}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @include('setting/profile.create-form')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"
                                            :disabled="settingProfileCreateForm.busy">{{ __('Save') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </ssky-setting-profile-create>
                <ssky-setting-profile-edit inline-template :setting_profile="settingProfile" :old="{}"
                    :errors="{}" @setting-profile-updated="updatedSettingProfile">
                    <div class="modal" tabindex="-1" role="dialog" id="setting-profile-edit-form">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST" action="#update" @submit="validateSettingProfileEditForm">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            {{ __('Edit') }}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @include('setting/profile.edit-form')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"
                                            :disabled="settingProfileEditForm.busy">{{ __('Update') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </ssky-setting-profile-edit>
                <div class="modal" tabindex="-1" role="dialog" id="setting-profile-destroy-confirm">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST" action="#destroy">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <strong>{{ __("Are you sure delete this settingProfile?") }}</strong>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                        <div class="col-md-6">
                                            <div class="form-control">@{{settingProfile.name}}</div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                                        <div class="col-md-6">
                                            <div class="form-control">@{{settingProfile.description}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">{{ __('Delete') }}</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @vuend
            </div>
            @vueif
        </ssky-setting-profile-list>
        @vuend
    </div>
</div>
@endsection