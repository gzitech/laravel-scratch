@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        @vueif
        <ssky-role-list inline-template :paginate="{{ $roles->toJson() }}">
            @vuend
            <div class="col-md-10">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Role</li>
                    </ol>
                </nav>
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="nav mr-auto">

                        </div>
                        <div class="nav ml-auto">
                            <a href="/role/create" role="button" class="btn btn-primary btn-sm" @vueif
                                @click.prevent="showRoleCreateForm" @vuend>Create</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Id</th>
<th scope="col">Role Name</th>
<th scope="col">Role Description</th>
<th scope="col">Right</th>
<th scope="col">Deleted At</th>
<th scope="col">Created At</th>
<th scope="col">Updated At</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @vueif
                                <tr v-for="role in roles" :key="role.id">
                                    <th scope="row">@{{ role.id }}</th>
                                     <td>@{{ role.id }}</td>
 <td>@{{ role.role_name }}</td>
 <td>@{{ role.role_description }}</td>
 <td>@{{ role.right }}</td>
 <td>@{{ role.deleted_at }}</td>
 <td>@{{ role.created_at }}</td>
 <td>@{{ role.updated_at }}</td>
                                    <td class="text-md-right">
                                        <a :href="showUrl(role.id)" title="Show"
                                            class="btn btn-outline-primary"><i
                                                class="fa fa-role-o"></i></a>
                                        <a href="#edit" title="Edit" class="btn btn-outline-primary"
                                            @click.prevent="showRoleEditForm(role)"><i
                                                class="fa fa-pencil"></i></a>
                                        <a href="#del" title="Destroy" class="btn btn-outline-danger"
                                            @click.prevent="showRoleDestroyConfirm(role)"><i
                                                class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                @vuend
                                @noneif
                                @foreach ($roles as $role)
                                <tr>
                                    <th scope="row">{{ $role->id }}</th>
                                     <td>{{ $role->id }}</td>
 <td>{{ $role->role_name }}</td>
 <td>{{ $role->role_description }}</td>
 <td>{{ $role->right }}</td>
 <td>{{ $role->deleted_at }}</td>
 <td>{{ $role->created_at }}</td>
 <td>{{ $role->updated_at }}</td>
                                    <td class="text-md-right">
                                        <a href="/role/{{ $role->id }}" title="Show"
                                            class="btn btn-outline-primary"><i
                                                class="fa fa-role-o"></i></a>
                                        <a href="/role/{{ $role->id }}/edit" title="Edit"
                                            class="btn btn-outline-primary"><i class="fa fa-pencil"></i></a>
                                        <a href="/role/{{ $role->id }}/destroy"
                                            title="Destroy" class="btn btn-outline-danger"><i
                                                class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @nonend
                            </tbody>
                        </table>
                    </div>
                    @if($roles->previousPageUrl() || $roles->nextPageUrl())
                    <div class="card-footer d-flex">
                        <div class="nav mr-auto">

                        </div>
                        <div class="nav ml-auto">
                            {{ $roles->links() }}
                        </div>
                    </div>
                    @endif
                </div>
                @vueif
                <ssky-role-create inline-template :old="{}" :errors="{}">
                    <div class="modal" tabindex="-1" role="dialog" id="role-create-form">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('role.index') }}"
                                    @submit="validateRoleCreateForm">
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
                                        @include('role.create-form')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"
                                            :disabled="roleCreateForm.busy">{{ __('Save') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </ssky-role-create>
                <ssky-role-edit inline-template :role="role" :old="{}"
                    :errors="{}" @role-updated="updatedRole">
                    <div class="modal" tabindex="-1" role="dialog" id="role-edit-form">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST" action="#update" @submit="validateRoleEditForm">
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
                                        @include('role.edit-form')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"
                                            :disabled="roleEditForm.busy">{{ __('Update') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </ssky-role-edit>
                <div class="modal" tabindex="-1" role="dialog" id="role-destroy-confirm">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST" action="#destroy">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <strong>{{ __("Are you sure delete this role?") }}</strong>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{ __('Id') }}</label>
    <div class="col-md-6">
        <div class="form-control">@{{role.id}}</div>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{ __('Role Name') }}</label>
    <div class="col-md-6">
        <div class="form-control">@{{role.role_name}}</div>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{ __('Role Description') }}</label>
    <div class="col-md-6">
        <div class="form-control">@{{role.role_description}}</div>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{ __('Right') }}</label>
    <div class="col-md-6">
        <div class="form-control">@{{role.right}}</div>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{ __('Deleted At') }}</label>
    <div class="col-md-6">
        <div class="form-control">@{{role.deleted_at}}</div>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{ __('Created At') }}</label>
    <div class="col-md-6">
        <div class="form-control">@{{role.created_at}}</div>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{ __('Updated At') }}</label>
    <div class="col-md-6">
        <div class="form-control">@{{role.updated_at}}</div>
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
        </ssky-role-list>
        @vuend
    </div>
</div>
@endsection