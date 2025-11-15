@extends('adminlte::page')

@section('title', 'Gestión de Estados')

@section('content_header')
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-toggle-on"></i>
                </div>
                <div>
                    <h1 class="title-main">Gestión de Estados</h1>
                    <p class="title-subtitle">Administración de los estados del sistema</p>
                </div>
            </div>

            {{-- Botón crear --}}
            <button type="button" class="btn-create" data-bs-toggle="modal" data-bs-target="#modalCrear">
                <i class="fas fa-plus"></i>
                <span>Nuevo Estado</span>
            </button>
        </div> 
    </div>
@stop

{{-- Estilos --}}
@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@stop

@section('content')
    @livewire('admin.estado-index')
@endsection

@section('js')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('cerrarModal', () => {
            const modales = document.querySelectorAll('.modal.show');
            modales.forEach(modal => {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            });

            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());

            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });
    });
</script>
@stop