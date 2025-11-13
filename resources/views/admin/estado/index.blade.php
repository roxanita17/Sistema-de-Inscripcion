@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Estado</h1>
@stop
@livewireStyles

@section('content')
    <div class="container mt-4">
        @livewire('admin.estado-index')
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


