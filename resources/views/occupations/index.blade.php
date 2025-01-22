@extends('layouts.main')
@section('title', 'Ocupaciones')
@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-12 col-md-6 text-start">
                    <h4 class="fw-bold">Lista de ocupaciones</h4>
                </div>
                @can('admin.occupations.create')
                    <div class="col-12 col-md-6 text-end">
                        <a href="{{ route('admin.occupations.create') }}" class="btn btn-dark rounded btn-sm">
                            Importar ocupaciones
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
                                    <th>IPS</th>
                                    <th>Fecha</th>
                                    <th>Urgencias</th>
                                    <th>Hospitalización</th>
                                    <th>UCI</th>
                                    <th>UCE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($occupations as $occupation)
                                    <tr>
                                        <td>{{ $occupation->ips->name }}</td>
                                        <td>{{ $occupation->date }} {{ $occupation->time }}</td>

                                        <td>
                                            <div class="row">
                                                <div class="col-12 mb-1">
                                                    <small style="font-size: 11px"><b>ADULTOS</b></small>:
                                                    @if ($occupation->urgency_adults > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $occupation->urgency_adults }}</div>
                                                    @else
                                                        {{ $occupation->urgency_adults }}
                                                    @endif
                                                </div>
                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>PEDIATRÍA</b></small>:
                                                    @if ($occupation->urgency_adults > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $occupation->urgency_pediatrics }}</div>
                                                    @else
                                                        {{ $occupation->urgency_pediatrics }}
                                                    @endif
                                                </div>
                                            </div>

                                            <br>

                                        </td>

                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>ADULTOS</b></small>:
                                                    @if ($occupation->hospitalization_adults > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $occupation->hospitalization_adults }}</div>
                                                    @else
                                                        {{ $occupation->hospitalization_adults }}
                                                    @endif
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>GINECO</b></small>:
                                                    @if ($occupation->hospitalization_obstetrics > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $occupation->hospitalization_obstetrics }}</div>
                                                    @else
                                                        {{ $occupation->hospitalization_obstetrics }}
                                                    @endif
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>PEDIATRÍA</b></small>:
                                                    @if ($occupation->hospitalization_pediatrics > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $occupation->hospitalization_pediatrics }}</div>
                                                    @else
                                                        {{ $occupation->hospitalization_pediatrics }}
                                                    @endif
                                                </div>
                                            </div>

                                        </td>

                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>ADULTOS</b></small>:
                                                    @if ($occupation->uci_adults > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $occupation->uci_adults }}</div>
                                                    @else
                                                        {{ $occupation->uci_adults }}
                                                    @endif
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>PEDIATRÍA</b></small>:
                                                    @if ($occupation->uci_pediatrics > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $occupation->uci_pediatrics }}</div>
                                                    @else
                                                        {{ $occupation->uci_pediatrics }}
                                                    @endif
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>NEONATAL</b></small>:
                                                    @if ($occupation->uci_neonatal > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $occupation->uci_neonatal }}</div>
                                                    @else
                                                        {{ $occupation->uci_neonatal }}
                                                    @endif
                                                </div>
                                            </div>
                                        </td>


                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>ADULTOS</b></small>:
                                                    @if ($occupation->uce_adults > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $occupation->uce_adults }}</div>
                                                    @else
                                                        {{ $occupation->uce_adults }}
                                                    @endif
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>PEDIATRÍA</b></small>:
                                                    @if ($occupation->uce_pediatrics > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $occupation->uce_pediatrics }}</div>
                                                    @else
                                                        {{ $occupation->uce_pediatrics }}
                                                    @endif
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>NEONATAL</b></small>:
                                                    @if ($occupation->uce_neonatal > 0)
                                                        <div style="font-size: 10px"
                                                            class="badge rounded-pill text-bg-dark">
                                                            {{ $occupation->uce_neonatal }}</div>
                                                    @else
                                                        {{ $occupation->uce_neonatal }}
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
                    [0, "DESC"]
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
                    info: "Mostrando _START_ a _END_ de _TOTAL_ Ocupaciones",
                    infoEmpty: "Mostrando 0 to 0 of 0 Ocupaciones",
                    infoFiltered: "(Filtrado de _MAX_ total Ocupaciones)",
                    thousands: ",",
                    lengthMenu: "Mostrar _MENU_ Ocupaciones",
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
