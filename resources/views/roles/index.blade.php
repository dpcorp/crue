@extends('layouts.main')
@section('title', 'Roles')
@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-12 col-md-6 text-start">
                    <h4 class="fw-bold">Lista de roles</h4>
                </div>
                @can('admin.roles.create')
                    <div class="col-12 col-md-6 text-end">
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-dark rounded btn-sm">
                            Crear rol
                        </a>
                    </div>
                @endcan
            </div>
        </div>
        @if (session('message'))
            <div class="col-12">
                <div class="alert alert-{{ session('color') }} alert-dismissible fade show d-flex justify-content-between align-items-center mb-4"
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
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Nombre rol</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($roles as $rol)
                                    <tr>
                                        <td>{{ $rol->name }}</td>
                                        <td class="text-center" width="200">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button class="btn btn-outline-primary btn-table border-0 btn-sm"
                                                    onclick="ShowRol({{ $rol->id }})">
                                                    <i class="fas fa-eye" style="pointer-events: none"></i>
                                                </button>
                                                <a class="btn btn-outline-dark btn-table border-0 btn-sm"
                                                    href="{{ route('admin.roles.edit', $rol->id) }}">
                                                    <i class="fas fa-edit" style="pointer-events: none"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="offcanvasContent"></div>
    </div>
    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                responsive: true,
                order: [
                    [0, "DESC"]
                ],
                paging: true,
                lengthMenu: [
                    [10, 25, 50],
                    [10, 25, 50]
                ],
                searching: true,
                language: {
                    decimal: "",
                    emptyTable: "No hay información",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ Roles",
                    infoEmpty: "Mostrando 0 to 0 of 0 Roles",
                    infoFiltered: "(Filtrado de _MAX_ total Roles)",
                    thousands: ",",
                    lengthMenu: "Mostrar _MENU_ Roles",
                    search: "Buscar:",
                    zeroRecords: "Sin resultados encontrados",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior",
                    },
                },
            });
        });
    </script>
    <script src="{{ asset('assets/js/app/roles/shoWRol.js') }}" defer></script>
@endsection
