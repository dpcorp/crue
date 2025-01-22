@extends('layouts.main')
@section('title', 'Saturaciones')
@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-12 col-md-6 text-start">
                    <h4 class="fw-bold">Lista de saturaciones</h4>
                </div>
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
                                @foreach ($saturation as $saturation)
                                    <tr>
                                        <td>{{ $saturation->ips->name }}</td>
                                        <td>{{ $saturation->date }} {{ $saturation->time }}</td>

                                        <td>
                                            <div class="row">
                                                <div class="col-12 mb-1">
                                                    <small style="font-size: 11px"><b>ADULTOS</b></small>:
                                                    @if ($saturation->urgency_adults < 50)
                                                        @php
                                                            $color = 'success';
                                                        @endphp
                                                    @elseif($saturation->urgency_adults < 100)
                                                        @php
                                                            $color = 'warning';
                                                        @endphp
                                                    @elseif($saturation->urgency_adults >= 100)
                                                        @php
                                                            $color = 'danger';
                                                        @endphp
                                                    @endif

                                                    <div style="font-size: 10px"
                                                        class="badge rounded-pill text-bg-{{ $color }}">
                                                        {{ number_format($saturation->urgency_adults, 1, ',', '') }}%
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>PEDIATRÍA</b></small>:
                                                    @if ($saturation->urgency_pediatrics < 50)
                                                        @php
                                                            $color = 'success';
                                                        @endphp
                                                    @elseif($saturation->urgency_pediatrics < 100)
                                                        @php
                                                            $color = 'warning';
                                                        @endphp
                                                    @elseif($saturation->urgency_pediatrics >= 100)
                                                        @php
                                                            $color = 'danger';
                                                        @endphp
                                                    @endif

                                                    <div style="font-size: 10px"
                                                        class="badge rounded-pill text-bg-{{ $color }}">
                                                        {{ number_format($saturation->urgency_pediatrics, 1, ',', '') }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>ADULTOS</b></small>:
                                                    @if ($saturation->hospitalization_adults < 50)
                                                        @php
                                                            $color = 'success';
                                                        @endphp
                                                    @elseif($saturation->hospitalization_adults < 100)
                                                        @php
                                                            $color = 'warning';
                                                        @endphp
                                                    @elseif($saturation->hospitalization_adults >= 100)
                                                        @php
                                                            $color = 'danger';
                                                        @endphp
                                                    @endif

                                                    <div style="font-size: 10px"
                                                        class="badge rounded-pill text-bg-{{ $color }}">
                                                        {{ number_format($saturation->hospitalization_adults, 1, ',', '') }}%
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>GINECO</b></small>:

                                                    @if ($saturation->hospitalization_obstetrics < 50)
                                                        @php
                                                            $color = 'success';
                                                        @endphp
                                                    @elseif($saturation->hospitalization_obstetrics < 100)
                                                        @php
                                                            $color = 'warning';
                                                        @endphp
                                                    @elseif($saturation->hospitalization_obstetrics >= 100)
                                                        @php
                                                            $color = 'danger';
                                                        @endphp
                                                    @endif

                                                    <div style="font-size: 10px"
                                                        class="badge rounded-pill text-bg-{{ $color }}">
                                                        {{ number_format($saturation->hospitalization_obstetrics, 1, ',', '') }}%
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>PEDIATRÍA</b></small>:

                                                    @if ($saturation->hospitalization_pediatrics < 50)
                                                        @php
                                                            $color = 'success';
                                                        @endphp
                                                    @elseif($saturation->hospitalization_pediatrics < 100)
                                                        @php
                                                            $color = 'warning';
                                                        @endphp
                                                    @elseif($saturation->hospitalization_pediatrics >= 100)
                                                        @php
                                                            $color = 'danger';
                                                        @endphp
                                                    @endif

                                                    <div style="font-size: 10px"
                                                        class="badge rounded-pill text-bg-{{ $color }}">
                                                        {{ number_format($saturation->hospitalization_pediatrics, 1, ',', '') }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>ADULTOS</b></small>:

                                                    @if ($saturation->uci_adults < 50)
                                                        @php
                                                            $color = 'success';
                                                        @endphp
                                                    @elseif($saturation->uci_adults < 100)
                                                        @php
                                                            $color = 'warning';
                                                        @endphp
                                                    @elseif($saturation->uci_adults >= 100)
                                                        @php
                                                            $color = 'danger';
                                                        @endphp
                                                    @endif

                                                    <div style="font-size: 10px"
                                                        class="badge rounded-pill text-bg-{{ $color }}">
                                                        {{ number_format($saturation->uci_adults, 1, ',', '') }}%
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>PEDIATRÍA</b></small>:

                                                    @if ($saturation->uci_pediatrics < 50)
                                                        @php
                                                            $color = 'success';
                                                        @endphp
                                                    @elseif($saturation->uci_pediatrics < 100)
                                                        @php
                                                            $color = 'warning';
                                                        @endphp
                                                    @elseif($saturation->uci_pediatrics >= 100)
                                                        @php
                                                            $color = 'danger';
                                                        @endphp
                                                    @endif

                                                    <div style="font-size: 10px"
                                                        class="badge rounded-pill text-bg-{{ $color }}">
                                                        {{ number_format($saturation->uci_pediatrics, 1, ',', '') }}%
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>NEONATAL</b></small>:

                                                    @if ($saturation->uci_neonatal < 50)
                                                        @php
                                                            $color = 'success';
                                                        @endphp
                                                    @elseif($saturation->uci_neonatal < 100)
                                                        @php
                                                            $color = 'warning';
                                                        @endphp
                                                    @elseif($saturation->uci_neonatal >= 100)
                                                        @php
                                                            $color = 'danger';
                                                        @endphp
                                                    @endif

                                                    <div style="font-size: 10px"
                                                        class="badge rounded-pill text-bg-{{ $color }}">
                                                        {{ number_format($saturation->uci_neonatal, 1, ',', '') }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="row">
                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>ADULTOS</b></small>:

                                                    @if ($saturation->uce_adults < 50)
                                                        @php
                                                            $color = 'success';
                                                        @endphp
                                                    @elseif($saturation->uce_adults < 100)
                                                        @php
                                                            $color = 'warning';
                                                        @endphp
                                                    @elseif($saturation->uce_adults >= 100)
                                                        @php
                                                            $color = 'danger';
                                                        @endphp
                                                    @endif

                                                    <div style="font-size: 10px"
                                                        class="badge rounded-pill text-bg-{{ $color }}">
                                                        {{ number_format($saturation->uce_adults, 1, ',', '') }}%
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>PEDIATRÍA</b></small>:

                                                    @if ($saturation->uce_pediatrics < 50)
                                                        @php
                                                            $color = 'success';
                                                        @endphp
                                                    @elseif($saturation->uce_pediatrics < 100)
                                                        @php
                                                            $color = 'warning';
                                                        @endphp
                                                    @elseif($saturation->uce_pediatrics >= 100)
                                                        @php
                                                            $color = 'danger';
                                                        @endphp
                                                    @endif

                                                    <div style="font-size: 10px"
                                                        class="badge rounded-pill text-bg-{{ $color }}">
                                                        {{ number_format($saturation->uce_pediatrics, 1, ',', '') }}%
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <small style="font-size: 11px"><b>NEONATAL</b></small>:

                                                    @if ($saturation->uce_neonatal < 50)
                                                        @php
                                                            $color = 'success';
                                                        @endphp
                                                    @elseif($saturation->uce_neonatal < 100)
                                                        @php
                                                            $color = 'warning';
                                                        @endphp
                                                    @elseif($saturation->uce_neonatal >= 100)
                                                        @php
                                                            $color = 'danger';
                                                        @endphp
                                                    @endif

                                                    <div style="font-size: 10px"
                                                        class="badge rounded-pill text-bg-{{ $color }}">
                                                        {{ number_format($saturation->uce_neonatal, 1, ',', '') }}%
                                                    </div>
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
                    [1, "DESC"]
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
                    info: "Mostrando _START_ a _END_ de _TOTAL_ saturaciones",
                    infoEmpty: "Mostrando 0 to 0 of 0 saturaciones",
                    infoFiltered: "(Filtrado de _MAX_ total saturaciones)",
                    thousands: ",",
                    lengthMenu: "Mostrar _MENU_ saturaciones",
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
    <script src="{{ asset('assets/js/app/saturations/mathematic.js?v=1.0.0') }}" defer></script>
@endsection
