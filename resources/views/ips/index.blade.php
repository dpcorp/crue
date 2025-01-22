@extends('layouts.main')
@section('title', 'Capacidad')
@section('content')
    <style>
        .word-break {
            word-break: break-word;
            /* Para romper palabras largas */
            white-space: normal;
            /* Para permitir múltiples líneas */
        }
    </style>
    <div class="row">
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-12 col-md-6 text-start">
                    <h4 class="fw-bold">Lista de capacidad</h4>
                </div>

                @can('admin.ips.create')
                    <div class="col-12 col-md-6 text-end">
                        <a href="{{ route('admin.ips.complexity') }}" class="btn btn-dark rounded btn-sm">
                            Importar complejidad
                        </a>
                        <a href="{{ route('admin.ips.create') }}" class="btn btn-dark rounded btn-sm">
                            Importar capacidad
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
                        <table id="basic-datatables" class="display table table-hover " style="width: 100%">
                            <thead>
                                <tr>
                                    <th>ips</th>
                                    <th>Complejidad</th>
                                    <th>Fecha</th>
                                    <th>Urgencias</th>
                                    <th>Hospitalización</th>
                                    <th>UCI</th>
                                    <th>UCE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ips as $ips)
                                    <tr>
                                        <td>{{ $ips->name }}</td>
                                        <td>{{ $ips->complexity ? $ips->complexity : 'N/A' }}</td>
                                        <td>{{ $ips->date }} {{ $ips->time }}</td>

                                        <td>
                                            <div class="row">
                                                <div class="col-12 mb-1">
                                                    <small style="font-size: 11px"><b>ADULTOS</b></small>:
                                                    @if ($ips->urgency_adults > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $ips->urgency_adults }}</div>
                                                    @else
                                                        {{ $ips->urgency_adults }}
                                                    @endif
                                                </div>
                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>PEDIATRÍA</b></small>:
                                                    @if ($ips->urgency_adults > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $ips->urgency_pediatrics }}</div>
                                                    @else
                                                        {{ $ips->urgency_pediatrics }}
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>ADULTOS</b></small>:
                                                    @if ($ips->hospitalization_adults > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $ips->hospitalization_adults }}</div>
                                                    @else
                                                        {{ $ips->hospitalization_adults }}
                                                    @endif
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>GINECO</b></small>:
                                                    @if ($ips->hospitalization_obstetrics > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $ips->hospitalization_obstetrics }}</div>
                                                    @else
                                                        {{ $ips->hospitalization_obstetrics }}
                                                    @endif
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>PEDIATRÍA</b></small>:
                                                    @if ($ips->hospitalization_pediatrics > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $ips->hospitalization_pediatrics }}</div>
                                                    @else
                                                        {{ $ips->hospitalization_pediatrics }}
                                                    @endif
                                                </div>
                                            </div>

                                        </td>

                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>ADULTOS</b></small>:
                                                    @if ($ips->uci_adults > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $ips->uci_adults }}</div>
                                                    @else
                                                        {{ $ips->uci_adults }}
                                                    @endif
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>PEDIATRÍA</b></small>:
                                                    @if ($ips->uci_pediatrics > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $ips->uci_pediatrics }}</div>
                                                    @else
                                                        {{ $ips->uci_pediatrics }}
                                                    @endif
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>NEONATAL</b></small>:
                                                    @if ($ips->uci_neonatal > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $ips->uci_neonatal }}</div>
                                                    @else
                                                        {{ $ips->uci_neonatal }}
                                                    @endif
                                                </div>
                                            </div>
                                        </td>


                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>ADULTOS</b></small>:
                                                    @if ($ips->uce_adults > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $ips->uce_adults }}</div>
                                                    @else
                                                        {{ $ips->uce_adults }}
                                                    @endif
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>PEDIATRÍA</b></small>:
                                                    @if ($ips->uce_pediatrics > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $ips->uce_pediatrics }}</div>
                                                    @else
                                                        {{ $ips->uce_pediatrics }}
                                                    @endif
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>NEONATAL</b></small>:
                                                    @if ($ips->uce_neonatal > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $ips->uce_neonatal }}</div>
                                                    @else
                                                        {{ $ips->uce_neonatal }}
                                                    @endif
                                                </div>
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
                    [2, "DESC"]
                ],
                paging: true,
                lengthMenu: [
                    [10, 25, 50],
                    [10, 25, 50]
                ],
                columnDefs: [{
                    "targets": 0, // Índice de la columna que deseas modificar (por ejemplo, la primera columna)
                    "width": "300px" // Ancho de la columna
                }],
                searching: true,
                language: {
                    decimal: "",
                    emptyTable: "No hay información",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ Capacidad",
                    infoEmpty: "Mostrando 0 to 0 of 0 Capacidad",
                    infoFiltered: "(Filtrado de _MAX_ total Capacidad)",
                    thousands: ",",
                    lengthMenu: "Mostrar _MENU_ Capacidad",
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
@endsection
