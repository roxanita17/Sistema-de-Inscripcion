<form
    action="{{ route('admin.transacciones.percentil.boton-percentil') }}"
    method="POST"
    class="d-inline"
    onsubmit="return confirm('¿Está seguro de ejecutar el percentil para este grado?')"
>
    @csrf

    <input type="hidden" name="grado_id" value="{{ $gradoId }}">

    <button
        type="submit"
        class="btn btn-primary"
        {{ !$anioEscolarActivo ? 'disabled' : '' }}
        title="{{ !$anioEscolarActivo
            ? 'Debe registrar un año escolar activo'
            : 'Ejecutar percentil y distribución de secciones' }}"
    >
        <i class="fas fa-calculator me-1"></i>
        Ejecutar Percentil
    </button>
</form>
