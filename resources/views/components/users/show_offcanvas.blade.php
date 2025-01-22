<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">
            <div class="row">
                <div class="col-3 d-flex align-items-center text-center">
                    <img src="{{ asset('assets/images/app/other.png') }}" alt="image profile" class="avatar-img rounded"
                        alt="...">
                </div>
                <div class="col-9 px-0 d-flex align-items-center">
                    <div class="row">
                        <div class="col-12">
                            <b>Información usuario</b>
                        </div>
                        <div class="col-12">
                            @if ($user->status == 1)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-warning">Inactivo</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="col-12 p-0 mb-3">
            <ul class="list-group border-0">
                <li class="list-group-item border-0 px-0">
                    <b>Nombre</b>: {{ $user->name }}
                </li>
                <li class="list-group-item border-0 px-0">
                    <b>Correo electrónico</b>: {{ $user->email }}
                </li>
                <li class="list-group-item border-0 px-0">
                    <b>Fecha creación</b>: {{ date('j F, Y - h:m A', strtotime($user->created_at)) }}
                </li>
            </ul>
        </div>

        <div class="col-12 border-bottom mb-3">
            <h5><b>Permisos</b></h5>
        </div>
        <div class="col-12">
            <ul class="list-group">
                @foreach ($permissions as $key => $permission)
                    <li class="list-group-item border-0 px-0"><b>
                            {{ $translation[$key] }}</b>:
                        {{ implode(', ', $permission) }}
                    </li>
                @endforeach
            </ul>
        </div>


    </div>
</div>
