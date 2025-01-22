@extends('layouts.main')
@section('title', 'Usuarios')
@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-12 col-md-6 text-start">
                    <h4 class="fw-bold">Crear usuario</h4>
                </div>
                <div class="col-12 col-md-6 text-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-dark rounded btn-sm">
                        Lista de usuarios
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="create-user-form" action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="username" name="name"
                                        placeholder="Nombre usuario">
                                    <label for="username">Nombre <b class="text-danger">*</b></label>
                                </div>
                                @if ($errors->has('name'))
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Correo usuario">
                                    <label for="email">Correo electrónico <b class="text-danger">*</b></label>
                                </div>
                                @if ($errors->has('email'))
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                @endif
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" oninput="validatePassword()" onblur="validatePassword()">
                                    <label for="password">Password <b class="text-danger">*</b></label>
                                    <div class="invalid-feedback" id="password-error"></div>
                                </div>
                                @if ($errors->has('password'))
                                    <small class="text-danger">{{ $errors->first('password') }}</small>
                                @endif
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="confirm-password"
                                        name="password_confirmation" placeholder="Repetir password"
                                        oninput="validateConfirmPassword()" onblur="validateConfirmPassword()">
                                    <label for="confirm-password">Repetir password <b class="text-danger">*</b></label>
                                    <div class="invalid-feedback" id="confirm-password-error"></div>
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <select name="rol" id="rol-id" class="form-select" onchange="filterRol(this);">
                                        <option value="" disabled selected>Selecciona un rol</option>
                                        @foreach ($roles as $rol)
                                            <option value="{{ $rol->name }}" <?php echo old('rol', '') == $rol->name ? 'selected' : ''; ?>>
                                                {{ $rol->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="">Roles <b class="text-danger">*</b></label>
                                    @if ($errors->has('rol'))
                                        <small class="text-danger">{{ $errors->first('rol') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12" id="div_roles" hidden>
                                <div class="accordion" id="accordionExample">

                                </div>
                            </div>

                            @can('admin.users.create')
                                <div class="col-12 text-end">
                                    <button disabled type="submit" class="btn btn-outline-dark rounded btn-sm" id="btn-create">
                                        Crear usuario
                                    </button>
                                </div>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/app/users/create_users.js') }}" defer></script>
    <script src="{{ asset('assets/js/app/users/filter_rol.js?v=1.0.0') }}" defer></script>
@endsection
