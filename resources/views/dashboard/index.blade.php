@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 col-xl-4 mb-4">
            <div class="card d-flex justify-content-center shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h5 class="mb-0"><i class="fas fa-minus"></i> {{ $user->rol }} <i class="fas fa-minus"></i>
                    </h5>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div class=" d-flex align-items-center justify-content-center border-dark"
                        style="width: 100px;height:100px">
                        <i class="fas fa-user-tie fa-5x mb-2"></i>
                    </div>
                </div>
                <ul class="list-group list-group-flush text-center ">
                    <li class="list-group-item d-flex justify-content-center text-center">{{ $user->name }}</li>
                    <li class="list-group-item d-flex justify-content-center text-center">{{ $user->email }}</li>
                    @isset($user->university)
                        <li class="list-group-item d-flex justify-content-center text-center">{{ $user->university->name }}</li>
                    @endisset
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        @if (session('message'))
            <div class="col-12 col-lg-6 col-xl-4 mb-4">
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
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
