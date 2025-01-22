<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">
            <b>Información del rol</b>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="col-12 p-0 mb-3">
            <ul class="list-group border-0">
                <li class="list-group-item border-0 px-0">
                    <b>Nombre</b>: {{ $role->name }}
                </li>
                <li class="list-group-item border-0 px-0">
                    <b>Fecha creación</b>: {{ date('j F, Y - h:m A', strtotime($role->created_at)) }}
                </li>
            </ul>
        </div>

        <div class="col-12 border-bottom mb-3">
            <h5><b>Permisos</b></h5>
        </div>
        <div class="col-12">
            @if (count($permissions) > 0)
                <ul class="list-group">
                    @foreach ($permissions as $key => $permission)
                        <li class="list-group-item border-0 px-0"><b>
                                {{ $translation[$key] }}</b>:
                            {{ implode(', ', $permission) }}
                        </li>
                    @endforeach
                </ul>
            @else
                <em>El rol <b>{{ $role->name }}</b> no tiene permisos asignados</em>
            @endif

        </div>


    </div>
</div>
