@extends('layouts.main')
@section('title', 'Dashboard')
@section('cdn')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
@endsection
@section('content')
    <style>
        #chart-container {
            width: 100%;
            height: auto;
            /* Altura dinámica sin restricciones máximas */
            position: relative;
        }

        #chartMathematic {
            width: 100%;
            height: 100%;
            /* El canvas ocupa el 100% de la altura del contenedor */
        }
    </style>
    <div class="row">
        <div class="col-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-more-than-hundred" data-bs-toggle="tab" href="#more_than_hundred"
                        role="tab" aria-controls="more_than_hundred" aria-selected="true">
                        <b>Porcentaje de saturación mayor al 100%</b>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-less-than-hundred" data-bs-toggle="tab" href="#less_than_hundred"
                        role="tab" aria-controls="less_than_hundred" aria-selected="false">
                        <b>Porcentaje de saturación menor al 100%</b>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-compartment-saturation" data-bs-toggle="tab" href="#compartment_saturation"
                        role="tab" aria-controls="compartment_saturation" aria-selected="false">
                        <b>Comportamiento de la saturación</b>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tab contents -->
        <div class="col-12">
            <div class="card shadow-sm mb-0" style="border-radius: 0px !important;">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-lg-6 col-xl-3">
                            <label for="exampleSelect" class="form-label">IPS</label>
                            <select type="text" class="form-select init-select2-multi" id="ips" multiple>
                                @foreach ($ips as $ip)
                                    <option value="{{ $ip->id }}">{{ $ip->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-6 col-xl-3">
                            <label for="exampleSelect" class="form-label">Complejidad</label>
                            <select type="text" class="form-select init-select2-multi" id="complexity" multiple>
                                <option value="ALTA">ALTA</option>
                                <option value="MEDIANA">MEDIANA</option>
                                <option value="BAJA">BAJA</option>
                            </select>
                        </div>
                        <div class="col-12 col-lg-6 col-xl-3">
                            <label for="exampleSelect" class="form-label">Servicio</label>
                            <select type="text" class="form-select init-select2-multi" id="services" name="services[]"
                                multiple>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-6 col-xl-3">
                            <label for="exampleSelect" class="form-label">Grupo</label>
                            <select type="text" class="form-select init-select2-multi" id="groups" multiple>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="exampleSelect" class="form-label">Fecha de inicio</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" id="date_start">
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="exampleSelect" class="form-label">Fecha de fin</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}" id="date_end">
                        </div>
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-dark btn-sm rounded" id="btn-filter"
                                attr-filter="more_than_hundred">Filtrar</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="more_than_hundred" role="tabpanel"
                    aria-labelledby="tab-more-than-hundred">
                    <div class="card shadow-sm" style="border-radius: 0px 0px 10px 10px !important;">
                        <div class="card-body">
                            <div id="chart-container" style="width: 100%; height: 100%;">
                                <canvas id="chartMathematic"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="less_than_hundred" role="tabpanel" aria-labelledby="tab-less-than-hundred">
                    <div class="card shadow-sm" style="border-radius: 0px 0px 10px 10px !important;">
                        <div class="card-body">
                            <div id="chart-container" style="width: 100%; height: 100%;">
                                <canvas id="chartMathematicLess"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="compartment_saturation" role="tabpanel"
                    aria-labelledby="tab-compartment-saturation">
                    <div class="card shadow-sm" style="border-radius: 0px 0px 10px 10px !important;">
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/app/saturations/chart.js') }}" defer></script>
@endsection
