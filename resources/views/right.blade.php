@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('nav.left')
        @vueif
        <ssky-right-list inline-template :paginate="{}">
            @vuend
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="nav mr-auto">

                        </div>
                        <div class="nav ml-auto">
                            <a href="/right/create" role="button" class="btn btn-primary btn-sm" @vueif
                                @click.prevent="showRightCreateForm" @vuend>Create</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Value</th>
                                    <th scope="col">Path</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @vueif
                                <tr v-for="right in rights" :key="right.id">
                                    <th scope="row">@{{ right.id }}</th>
                                    <td>@{{ right.right_name }}</td>
                                    <td>@{{ right.right_value }}</td>
                                    <td>@{{ right.right_path }}</td>
                                    <td class="text-md-right">
                                        <a :href="showUrl(right.id)" title="Show" class="btn btn-outline-primary"><i
                                                class="fa fa-user-o"></i></a>
                                        <a href="#edit" title="Edit" class="btn btn-outline-primary"
                                            @click.prevent="showRightEditForm(right)"><i class="fa fa-pencil"></i></a>
                                        <a href="#del" title="Destroy" class="btn btn-outline-danger"
                                            @click.prevent="showRightDestroyConfirm(right)"><i
                                                class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                @vuend
                                @noneif
                                @foreach ($rights as $right)
                                <tr>
                                    <th scope="row">{{ $right->id }}</th>
                                    <td>{{ $right->right_name }}</td>
                                    <td>{{ $right->right_value }}</td>
                                    <td>{{ $right->right_path }}</td>
                                    <td class="text-md-right">
                                        <a href="/right/{{ $right->id }}" title="Show"
                                            class="btn btn-outline-primary"><i class="fa fa-user-o"></i></a>
                                        <a href="/right/{{ $right->id }}/edit" title="Edit"
                                            class="btn btn-outline-primary"><i class="fa fa-pencil"></i></a>
                                        <a href="/right/{{ $right->id }}/destroy" title="Destroy"
                                            class="btn btn-outline-danger"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @nonend
                            </tbody>
                        </table>
                    </div>
                </div>
                @vueif
                <ssky-right-create inline-template :old="{}" :errors="{}">
                    <div class="modal" tabindex="-1" role="dialog" id="right-create-form">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST" action="/right" @submit="validateRightCreateForm">
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
                                        @include('right.create-form')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"
                                            :disabled="rightCreateForm.busy">{{ __('Save') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </ssky-right-create>
                <ssky-right-edit inline-template :right="right" :old="{}" :errors="{}" @right-updated="updatedRight">
                    <div class="modal" tabindex="-1" role="dialog" id="right-edit-form">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <form method="POST" action="#update" @submit="validateRightEditForm">
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
                                        @include('right.edit-form')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"
                                            :disabled="rightEditForm.busy">{{ __('Update') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </ssky-right-edit>
                <div class="modal" tabindex="-1" role="dialog" id="right-destroy-confirm">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST" action="#destroy">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <strong>{{ __("Are you sure delete this right?") }}</strong>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label
                                            class="col-md-4 col-form-label text-md-right">{{ __('Right Name') }}</label>
                                        <div class="col-md-6">
                                            <div class="form-control">@{{right.right_name}}</div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label
                                            class="col-md-4 col-form-label text-md-right">{{ __('Right Value') }}</label>
                                        <div class="col-md-6">
                                            <div class="form-control">@{{right.right_value}}</div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label
                                            class="col-md-4 col-form-label text-md-right">{{ __('Right Path') }}</label>
                                        <div class="col-md-6">
                                            <div class="form-control">@{{right.right_path}}</div>
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
        </ssky-right-list>
        @vuend
    </div>
</div>
@endsection