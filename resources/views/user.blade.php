@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        @vueif
        <ssky-user-list inline-template :paginate="{{ $users->toJson() }}">
            @vuend
            <div class="col-md-10">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">User</li>
                    </ol>
                </nav>
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="nav mr-auto">

                        </div>
                        <div class="nav ml-auto">
                            <a href="/user/create" role="button" class="btn btn-primary btn-sm" @vueif
                                @click.prevent="showUserCreateForm" @vuend>Create</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @vueif
                                <tr v-for="user in users" :key="user.id">
                                    <th scope="row">@{{ user.id }}</th>
                                    <td>@{{ user.first_name }}</td>
                                    <td>@{{ user.last_name }}</td>
                                    <td>@{{ user.email }}</td>
                                    <td class="text-md-right">
                                        <a :href="showUrl(user.id)" title="Show"
                                            class="btn btn-outline-primary"><i
                                                class="fa fa-user-o"></i></a>
                                        <a href="#edit" title="Edit" class="btn btn-outline-primary"
                                            @click.prevent="showUserEditForm(user)"><i
                                                class="fa fa-pencil"></i></a>
                                        <a href="#del" title="Destroy" class="btn btn-outline-danger"
                                            @click.prevent="showUserDestroyConfirm(user)"><i
                                                class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                @vuend
                                @noneif
                                @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-md-right">
                                        <a href="/user/{{ $user->id }}" title="Show"
                                            class="btn btn-outline-primary"><i
                                                class="fa fa-user-o"></i></a>
                                        <a href="/user/{{ $user->id }}/edit" title="Edit"
                                            class="btn btn-outline-primary"><i class="fa fa-pencil"></i></a>
                                        <a href="/user/{{ $user->id }}/destroy"
                                            title="Destroy" class="btn btn-outline-danger"><i
                                                class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @nonend
                            </tbody>
                        </table>
                    </div>
                    @if($users->previousPageUrl() || $users->nextPageUrl())
                    <div class="card-footer d-flex">
                        <div class="nav mr-auto">

                        </div>
                        <div class="nav ml-auto">
                            {{ $users->links() }}
                        </div>
                    </div>
                    @endif
                </div>
                @vueif
                <ssky-user-create inline-template :old="{}" :errors="{}">
                    <div class="modal" tabindex="-1" role="dialog" id="user-create-form">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('user.index') }}"
                                    @submit="validateUserCreateForm">
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
                                        @include('user.create-form')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"
                                            :disabled="userCreateForm.busy">{{ __('Save') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </ssky-user-create>
                <ssky-user-edit inline-template :user="user" :old="{}"
                    :errors="{}" @user-updated="updatedUser">
                    <div class="modal" tabindex="-1" role="dialog" id="user-edit-form">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST" action="#update" @submit="validateUserEditForm">
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
                                        @include('user.edit-form')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"
                                            :disabled="userEditForm.busy">{{ __('Update') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </ssky-user-edit>
                <div class="modal" tabindex="-1" role="dialog" id="user-destroy-confirm">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST" action="#destroy">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <strong>{{ __("Are you sure delete this user?") }}</strong>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
                                        <div class="col-md-6">
                                            <div class="form-control">@{{user.first_name}}</div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
                                        <div class="col-md-6">
                                            <div class="form-control">@{{user.last_name}}</div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                                        <div class="col-md-6">
                                            <div class="form-control">@{{user.email}}</div>
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
        </ssky-user-list>
        @vuend
    </div>
</div>
@endsection