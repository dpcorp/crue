@extends('layouts.main')
@section('title', 'Usuarios')
@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-12 col-md-6 text-start">
                    <h4 class="fw-bold">Editar usuario</h4>
                </div>
                <div class="col-12 col-md-6 text-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-dark rounded btn-sm">
                        Lista de usuarios
                    </a>
                </div>
            </div>
        </div>
        @if (session('message'))
            <div class="col-12">
                <div class="alert alert-{{ session('color') }} alert-dismissible fade show d-flex justify-content-bewteen align-items-center mb-4"
                    role="alert">
                    <div class="col-10">
                        <i class="fa-solid fa-circle-info"></i> <b>{{ session('message') }}</b>
                    </div>
                    <div class="col-2 d-flex align-items-center text-center">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-12 col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="create-user-form" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" value="{{ $user->name }}" name="name"
                                        placeholder="Nombre usuario">
                                    <label for="username">Nombre <b class="text-danger">*</b></label>
                                </div>
                                @if ($errors->has('name'))
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                @endif
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" value="{{ $user->email }}"
                                        name="email" placeholder="Correo usuario">
                                    <label for="email">Correo electrónico <b class="text-danger">*</b></label>
                                </div>
                                @if ($errors->has('email'))
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                @endif
                            </div>

                            <input hidden id="id_user" value="{{ $user->id }}">

                            <div class="col-12">
                                <div class="form-floating">
                                    <select name="rol" id="rol-id" class="form-select init-select2"
                                        onchange="filterRol(this);">
                                        <option value="" disabled selected>Selecciona un rol</option>
                                        @foreach ($roles as $rol)
                                            <option value="{{ $rol->name }}"
                                                {{ old('rol', $user->rol) === $rol->name ? 'selected' : '' }}>
                                                {{ $rol->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="">Roles <b class="text-danger">*</b></label>
                                </div>
                            </div>

                            <div class="col-12" id="div_roles" hidden>
                                <div class="accordion" id="accordionExample">

                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check p-0">
                                    <input class="form-check-input" type="radio" name="status" value="1"
                                        id="status_activo" @if ($user->status == 1) checked @endif>
                                    <label class="form-check-label" for="status_activo">Activo</label>
                                </div>
                                <div class="form-check p-0">
                                    <input class="form-check-input" type="radio" name="status" value="0"
                                        id="status_inactivo" @if ($user->status == 0) checked @endif>
                                    <label class="form-check-label" for="status_inactivo">Inactivo</label>
                                </div>
                                @if ($errors->has('status'))
                                    <small class="text-danger">{{ $errors->first('status') }}</small>
                                @endif
                            </div>
                            @can('admin.users.edit')
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-dark btn-rounded btn-sm">
                                        Editar usuario
                                    </button>
                                </div>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5" >
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.users.updatePassword', $user->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <input type="text" id="id" name="id" hidden value="{{ $user->id }}">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" id="password" class="form-control" placeholder="Nombre"
                                        name="password" value="{{ old('password', '') }}">
                                    <label for="">Contraseña  <b class="text-danger">*</b></label>
                                    @if ($errors->has('password'))
                                        <small class="text-danger">{{ $errors->first('password') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" id="password_confirmation" class="form-control"
                                        placeholder="Nombre" name="password_confirmation">
                                    <label for="">Confirmar contraseña  <b class="text-danger">*</b></label>
                                    @if ($errors->has('password_confirmation'))
                                        <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <button class="btn btn-dark btn-sm ">Actualizar contraseña</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/app/users/filter_rol.js?v=1.0.0') }}" defer></script>
@endsection
