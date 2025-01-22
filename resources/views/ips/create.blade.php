@extends('layouts.main')
@section('title', 'Usuarios')
@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-12 col-md-6 text-start">
                    <h4 class="fw-bold">Importar IPS</h4>
                </div>
                <div class="col-12 col-md-6 text-end">
                    <a href="{{ route('admin.ips.index') }}" class="btn btn-dark rounded btn-sm">
                        Lista de IPS
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="uploadExcelForm" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 mb-3">
                            <label for="formFile" class="form-label">Selecciona el archivo de "Capacidad"</label>
                            <input class="form-control" type="file" id="file" name="file"
                                accept=".xlsx, .xls, .csv">
                        </div>
                        <div class="col-12 text-end">
                            <button type="button" id="uploadButton" class="btn btn-dark btn-sm rounded">
                                Cargar archivo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="col-12 mb-4" style="display: none" id="spinner">
                <div class="sk-fading-circle">
                    <div class="sk-circle1 sk-circle"></div>
                    <div class="sk-circle2 sk-circle"></div>
                    <div class="sk-circle3 sk-circle"></div>
                    <div class="sk-circle4 sk-circle"></div>
                    <div class="sk-circle5 sk-circle"></div>
                    <div class="sk-circle6 sk-circle"></div>
                    <div class="sk-circle7 sk-circle"></div>
                    <div class="sk-circle8 sk-circle"></div>
                    <div class="sk-circle9 sk-circle"></div>
                    <div class="sk-circle10 sk-circle"></div>
                    <div class="sk-circle11 sk-circle"></div>
                    <div class="sk-circle12 sk-circle"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="display: none" id="content">
        <div class="col-12 col-lg-12  col-xxl-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-center px-4" style="height: 7em;">
                    <div class="col">
                        <i class="fas fa-user fa-3x"></i>
                    </div>
                    <div class="col">
                        <div class="col-12 text-end">
                            <h3><b id="total_ips">0</b></h3>
                        </div>
                        <div class="col-12 text-end">
                            <small class="text-muted"><strong>Ips cargadas</strong></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 col-lg-12  col-xxl-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-center px-4" style="height: 7em;">
                    <div class="col">
                        <i class="fas fa-undo-alt fa-3x"></i>
                    </div>
                    <div class="col">
                        <div class="col-12 text-end">
                            <h3><b id="to_update">0</b></h3>
                        </div>
                        <div class="col-12 text-end">
                            <small class="text-muted"><strong>Por actualizar</strong></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12  col-xxl-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-center px-4" style="height: 7em;">
                    <div class="col">
                        <i class="fas fa-plus fa-3x"></i>
                    </div>
                    <div class="col">
                        <div class="col-12 text-end">
                            <h3><b id="to_create">0</b></h3>
                        </div>
                        <div class="col-12 text-end">
                            <small class="text-muted"><strong>Por crear</strong></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-center">
            <div class="col-12 col-lg-7 col-xl-4">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-center px-4" style="height: 7em;">
                        <button type="button" id="btn-import" class="btn btn-success btn-sm rounded">
                            Alamacenar información cargada
                        </button>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="{{ asset('assets/js/app/ips/LoadFile.js?v=1.0.0') }}" defer></script>
@endsection
