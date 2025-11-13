@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Localidad</h1>
@stop

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@livewireStyles

@section('content')
<div class="container mt-4">
    @livewire('admin.localidad-index')
</div>
@endsection


@livewireScripts
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('cerrarModal', () => {
            // Cerrar todos los modales abiertos
            const modales = document.querySelectorAll('.modal.show');
            modales.forEach(modal => {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            });

            //Eliminar manualmente los backdrop (fondo oscuro)
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());

            // Asegurar que el body se desbloquee
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });
    });
</script>