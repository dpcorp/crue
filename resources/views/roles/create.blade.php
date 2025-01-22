@extends('layouts.main')
@section('title', 'Roles')
@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-12 col-md-6 text-start">
                    <h4 class="fw-bold">Crear rol</h4>
                </div>
                <div class="col-12 col-md-6 text-end">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-dark rounded btn-sm">
                        Lista de roles
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" placeholder="Nombre" name="name"
                                        value="{{ old('name', '') }}">
                                    <label for="">Nombre <b class="text-danger">*</b></label>
                                    @if ($errors->has('name'))
                                        <small class="text-danger">{{ $errors->first('name') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="accordion" id="accordionExample">
                                    @foreach ($groups_data as $key => $group)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="{{ str_replace(' ', '', $key) }}">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#{{ str_replace(' ', '', $key) }}_collapse"
                                                    aria-expanded="false"
                                                    aria-controls="{{ str_replace(' ', '', $key) }}_collapse">
                                                    <span class="badge rounded-pill text-bg-secondary mx-0">
                                                        {{ count($group) }}
                                                    </span>
                                                    <div class="mx-1">{{ $key }}</div>
                                                </button>
                                            </h2>
                                            <div id="{{ str_replace(' ', '', $key) }}_collapse"
                                                class="accordion-collapse collapse"
                                                aria-labelledby="{{ str_replace(' ', '', $key) }}"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row border-bottom  py-2 border-end-0 border-start-0">
                                                        <div class="col-12 d-flex justify-content-start">
                                                            <div class="form-check">

                                                                <input class="form-check-input" type="checkbox" checked
                                                                    onclick="toggleCheckboxes('{{ strtolower($key) }}')"
                                                                    id="{{ strtolower($key) }}_all">
                                                                <label class="form-check-label"
                                                                    for="{{ strtolower($key) }}_all">
                                                                    Seleccionar/Quitar todos los permisos
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @foreach ($group as $key_2 => $permissions)
                                                        <div class="row border-bottom py-2 border-end-0 border-start-0">

                                                            <div
                                                                class="col-12 col-lg-5 col-xl-4 col-xxl-3 d-flex align-items-center mb-3 mb-md-0">
                                                                <b>{{ isset($traduccion[$key_2]) ? $traduccion[$key_2] : $key }}</b>
                                                            </div>
                                                            <div
                                                                class="col-12 col-lg-7 col-xl-8 col-xxl-9 d-flex justify-content-start">
                                                                <div class="row">
                                                                    @foreach ($permissions as $permission)
                                                                        <div
                                                                            class="col-12  col-lg-5 col-xl-auto mb-lg-3 mb-xl-0">
                                                                            <div class="form-check">
                                                                                <input
                                                                                    class="all_{{ strtolower($key) }} module_{{ strtolower(isset($traduccion[$key_2]) ? $traduccion[$key_2] : $key) }} form-check-input"
                                                                                    type="checkbox"
                                                                                    value="{{ $permission->id }}"
                                                                                    id="{{ $permission->name }}"
                                                                                    name="permissions[{{ $permission->id }}]"
                                                                                    checked>
                                                                                <label class="form-check-label"
                                                                                    for="{{ $permission->name }}">
                                                                                    {{ $permission->description }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @can('admin.roles.edit')
                                <div class="col-12 text-end">
                                    <button class="btn btn-outline-dark rounded btn-sm">Crear rol</button>
                                </div>
                            @endcan

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/app/roles/Permissions.js') }}" defer></script>
@endsection
