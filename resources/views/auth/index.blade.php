@extends('layouts.login')

@section('content')
    <style>
        .login-image-col {
            background-color: #f8f9fa;
            /* Cambia esto según el diseño que necesites */
            display: flex;
            justify-content: center;
            /* Centra la imagen */
            align-items: center;
            /* Centra la imagen */
            overflow: hidden;
            /* Evita que las imágenes se desborden */
            position: relative;
            /* Necesario para el fondo fijo */
            background-color: #ffffff;
            /* Imagen de fondo */
            background-size: cover;
            /* Ajusta la imagen para cubrir el contenedor */
            background-position: center;
            /* Centra la imagen */
            border-radius: 15px;
            /* Bordes redondeados */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            /* Opcional: sombra para un efecto elevado */
        }

        .internal-image {
            position: absolute;
            /* Para colocar la imagen interna donde lo necesites */
            top: 50%;
            /* Ajusta según sea necesario */
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            /* Cambia el tamaño según sea necesario */
            max-width: 300px;
            /* Un ancho máximo opcional para la imagen interna */
        }

        .login-container {
            height: 100vh;
            /* Asegura que ocupe toda la altura de la pantalla */
        }
    </style>
    <div class="container-fluid full-height">
        <div class="row no-gutters full-height">
            <div class="col-12 col-lg-7 d-none d-lg-block px-0">
                <div class="row h-100 p-4">
                    <div class="login-image-col col-12 ">
                        <div>
                            <img src="{{ asset('assets/images/app/version_alcaldia.svg') }}" alt="Background"
                                class="internal-image" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5 d-flex justify-content-center align-items-center px-0">
                <div class="col-10 col-sm-7 col-lg-8 col-xl-7 col-xxl-6">
                    <div class="card border-0 bg-transparent">
                        <div class="card-body">
                            <div class="col-12">
                                <div class="row">
                                    @if (session('message'))
                                        <div class="col-12">
                                            <div class="alert alert-{{ session('color') }} alert-dismissible fade show d-flex justify-content-bewteen align-items-center mb-4"
                                                role="alert">
                                                <div class="col-10">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <i class="{{ session('icon') }}"></i>
                                                            <b>{{ session('title') }}</b>
                                                        </div>
                                                        <div class="col-12">
                                                            <small>{{ session('message') }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2 d-flex align-items-center text-center">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12">
                                <form method="POST" action="{{ route('auth.login') }}">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-12 mb-0">
                                            <h1 className="text-dark fw-semibold" style="font-weight: semibold">
                                                CRUE
                                            </h1>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center">
                                            <div class="row">
                                                <div class="col-12 h2"><b>¡Bienvenido!</b></div>
                                                <div class="col-12 text-muted">Ingresa tu usuario y contraseña para iniciar
                                                    sesión
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <input type="email" class="form-control" placeholder="Correo electrónico"
                                                id="email" name="email">
                                            @if ($errors->has('email'))
                                                <small class="text-danger">{{ $errors->first('email') }}</small>
                                            @endif
                                        </div>
                                        <div class="col-12">
                                            <div class="input-group">
                                                <input type="password" class="form-control" placeholder="Contraseña"
                                                    id="password" name="password">
                                                <button class="btn btn-light btn-sm input-group-button border-secondary"
                                                    id="togglePassword" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Ver" type="button">
                                                    <i class="fas fa-eye" id="icon_view_password"
                                                        style="pointer-events: none;"></i>
                                                </button>
                                            </div>
                                            @if ($errors->has('password'))
                                                <small class="text-danger">{{ $errors->first('password') }}</small>
                                            @endif
                                        </div>
                                        <div class="col-12 d-grid mb-2">
                                            <button class="btn btn-dark" type="submit">Ingresar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/app/auth/login.js') }}" defer></script>
@endsection
