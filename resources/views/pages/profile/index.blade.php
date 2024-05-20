@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <label for="profile-picture">
                        <div class="image-container">
                            <img src="{{ Auth::user()->getPhoto() }}" alt="avatar" id="profile-image"
                                class="rounded-circle img-fluid" style="width: 150px;">
                            <div class="logo-overlay">
                                <i class="mdi mdi-camera"></i>
                            </div>
                        </div>
                    </label>
                    <h5 class="my-3">{{ Auth()->user()->name }}</h5>
                    <form action="" method="POST" enctype="multipart/form-data" id="picture-form">
                        @csrf
                        @method('PUT')
                        <input type="file" name="foto" id="profile-picture" style="display: none;">
                        <button type="button" id="edit-button" class="btn btn-sm btn-success">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card mb-4">
                <form action="" id="form-profile">
                    <div class="card-body">
                        @cannot('admin')
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ __("Fullname") }}</p>
                            </div>
                            <div class="col-sm-1">
                                <p class="mb-0">:</p>
                            </div>
                            <div class="col-sm-8 text-start">
                                <input type="text" name="name" id="name" class="no-border" size="50"
                                    value="{{ $user?->pegawai->name }}" autocomplete="off">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ __("Address") }}</p>
                            </div>
                            <div class="col-sm-1">
                                <p class="mb-0">:</p>
                            </div>
                            <div class="col-sm-8 text-start">
                                <input type="text" name="address" id="address" class="no-border" size="50"
                                    value="{{ $user?->pegawai->address }}" autocomplete="off">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ __("Phone") }}</p>
                            </div>
                            <div class="col-sm-1">
                                <p class="mb-0">:</p>
                            </div>
                            <div class="col-sm-8 text-start">
                                <input type="text" name="phone" id="phone" class="no-border" size="50"
                                    value="{{ $user?->pegawai->phone }}" autocomplete="off">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ __("Position") }}</p>
                            </div>
                            <div class="col-sm-1">
                                <p class="mb-0">:</p>
                            </div>
                            <div class="col-sm-8 text-start">
                                <input type="text" name="position" id="position" class="no-border" size="50"
                                    value="{{ $user?->pegawai->position }}" autocomplete="off" readonly>
                            </div>
                        </div>
                        <hr>
                        @endcan
                        @can('admin')
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">{{ __("Username") }}</p>
                            </div>
                            <div class="col-sm-1">
                                <p class="mb-0">:</p>
                            </div>
                            <div class="col-sm-8 text-start">
                                <input type="text" name="username" id="username" class="no-border" size="50"
                                    value="{{ $user->username }}" autocomplete="off" readonly>
                            </div>
                        </div>
                        <hr>
                        @endcan
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-1">
                                <p class="mb-0">:</p>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="email" id="email" class="no-border"
                                    value="{{ $user?->email }}" size="50" autocomplete="off">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Password</p>
                            </div>
                            <div class="col-sm-1">
                                <p class="mb-0">:</p>
                            </div>
                            <div class="col-sm-8">
                                <input type="password" name="password" id="password" class="no-border" size="50"
                                    value="" placeholder="Kosongi jika tidak ingin merubah password" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

  
@endsection
@widget('profile')

