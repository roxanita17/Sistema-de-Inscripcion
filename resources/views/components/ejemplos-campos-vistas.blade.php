@extends('adminlte::page')

@section('css')
    {{-- Estilos modernos reutilizados del sistema --}}
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('css/view-styles.css') }}">

@stop

@section('title', 'Gestión de Docentes')

@section('content_header')
    <div class="main-container">
        <!-- Header -->
        <div class="content-header-modern">
            <div class="header-content">
                <div class="header-title">
                    <div class="icon-wrapper">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div>
                        <h1 class="title-main">Biblioteca de Campos de Formulario</h1>
                        <p class="title-subtitle">Todos los tipos de campos disponibles con estilos modernos</p>
                    </div>
                </div> 
            </div>
        </div>

        <!-- Formulario con todos los tipos de campos -->
        <div class="card-modern">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div>
                        <h3>Campos de Texto</h3>
                        <p>Inputs básicos y especializados</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern">
                <form class="form-modern">
                    
                    <!-- 1. INPUT TEXT BÁSICO -->
                    <div class="form-group-modern">
                        <label for="text_basic" class="form-label-modern">
                            <i class="fas fa-font"></i>
                            Campo de Texto Básico
                            <span class="required-badge">*</span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control-modern" 
                            id="text_basic" 
                            placeholder="Ingrese texto aquí">
                        <small class="form-text-modern">
                            <i class="fas fa-info-circle"></i>
                            Campo de texto simple
                        </small>
                    </div>

                    <!-- 2. INPUT TEXT CON ERROR -->
                    <div class="form-group-modern">
                        <label for="text_error" class="form-label-modern">
                            <i class="fas fa-exclamation-triangle"></i>
                            Campo con Error
                        </label>
                        <input 
                            type="text" 
                            class="form-control-modern is-invalid" 
                            id="text_error" 
                            value="Texto inválido">
                        <div class="invalid-feedback-modern">
                            <i class="fas fa-exclamation-circle"></i>
                            Este campo contiene un error de validación
                        </div>
                    </div>

                    <!-- 3. INPUT TEXT CON ÉXITO -->
                    <div class="form-group-modern">
                        <label for="text_success" class="form-label-modern">
                            <i class="fas fa-check-circle"></i>
                            Campo Validado
                        </label>
                        <input 
                            type="text" 
                            class="form-control-modern is-valid" 
                            id="text_success" 
                            value="Texto válido">
                        <div class="valid-feedback-modern">
                            <i class="fas fa-check-circle"></i>
                            Campo validado correctamente
                        </div>
                    </div>

                    <!-- 4. INPUT TEXT DESHABILITADO -->
                    <div class="form-group-modern">
                        <label for="text_disabled" class="form-label-modern">
                            <i class="fas fa-lock"></i>
                            Campo Deshabilitado
                        </label>
                        <input 
                            type="text" 
                            class="form-control-modern" 
                            id="text_disabled" 
                            value="No editable"
                            disabled>
                    </div>

                    <!-- ROW CON DOS COLUMNAS -->
                    <div class="form-row-modern">
                        <!-- 5. EMAIL -->
                        <div class="form-group-modern">
                            <label for="email" class="form-label-modern">
                                <i class="fas fa-envelope"></i>
                                Correo Electrónico
                            </label>
                            <input 
                                type="email" 
                                class="form-control-modern" 
                                id="email" 
                                placeholder="usuario@ejemplo.com">
                        </div>

                        <!-- 6. TELÉFONO -->
                        <div class="form-group-modern">
                            <label for="phone" class="form-label-modern">
                                <i class="fas fa-phone"></i>
                                Teléfono
                            </label>
                            <input 
                                type="tel" 
                                class="form-control-modern" 
                                id="phone" 
                                placeholder="0412-1234567">
                        </div>
                    </div>

                    <!-- ROW CON TRES COLUMNAS -->
                    <div class="form-row-modern" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                        <!-- 7. NUMBER -->
                        <div class="form-group-modern">
                            <label for="number" class="form-label-modern">
                                <i class="fas fa-hashtag"></i>
                                Número
                            </label>
                            <input 
                                type="number" 
                                class="form-control-modern" 
                                id="number" 
                                placeholder="0">
                        </div>

                        <!-- 8. DATE -->
                        <div class="form-group-modern">
                            <label for="date" class="form-label-modern">
                                <i class="fas fa-calendar"></i>
                                Fecha
                            </label>
                            <input 
                                type="date" 
                                class="form-control-modern" 
                                id="date">
                        </div>

                        <!-- 9. TIME -->
                        <div class="form-group-modern">
                            <label for="time" class="form-label-modern">
                                <i class="fas fa-clock"></i>
                                Hora
                            </label>
                            <input 
                                type="time" 
                                class="form-control-modern" 
                                id="time">
                        </div>
                    </div>

                    <!-- 10. PASSWORD -->
                    <div class="form-group-modern">
                        <label for="password" class="form-label-modern">
                            <i class="fas fa-key"></i>
                            Contraseña
                            <span class="required-badge">*</span>
                        </label>
                        <div class="input-group-modern">
                            <input 
                                type="password" 
                                class="form-control-modern" 
                                id="password" 
                                placeholder="••••••••">
                            <button type="button" class="input-addon-modern" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="form-text-modern">
                            <i class="fas fa-info-circle"></i>
                            Mínimo 8 caracteres
                        </small>
                    </div>

                    <!-- 11. URL -->
                    <div class="form-group-modern">
                        <label for="url" class="form-label-modern">
                            <i class="fas fa-link"></i>
                            URL / Sitio Web
                        </label>
                        <input 
                            type="url" 
                            class="form-control-modern" 
                            id="url" 
                            placeholder="https://ejemplo.com">
                    </div>

                    <!-- 12. SEARCH -->
                    <div class="form-group-modern">
                        <label for="search" class="form-label-modern">
                            <i class="fas fa-search"></i>
                            Búsqueda
                        </label>
                        <div class="input-group-modern">
                            <span class="input-prefix-modern">
                                <i class="fas fa-search"></i>
                            </span>
                            <input 
                                type="search" 
                                class="form-control-modern with-prefix" 
                                id="search" 
                                placeholder="Buscar...">
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <!-- CARD: SELECTS Y OPCIONES -->
        <div class="card-modern">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <div>
                        <h3>Selects y Opciones</h3>
                        <p>Menús desplegables y selección múltiple</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern">
                <form class="form-modern">
                    
                    <!-- 13. SELECT SIMPLE -->
                    <div class="form-group-modern">
                        <label for="select_simple" class="form-label-modern">
                            <i class="fas fa-chevron-down"></i>
                            Select Simple
                            <span class="required-badge">*</span>
                        </label>
                        <select class="form-control-modern" id="select_simple">
                            <option value="">Seleccione una opción</option>
                            <option value="1">Opción 1</option>
                            <option value="2">Opción 2</option>
                            <option value="3">Opción 3</option>
                        </select>
                    </div>

                    <!-- 14. SELECT CON GRUPOS -->
                    <div class="form-group-modern">
                        <label for="select_group" class="form-label-modern">
                            <i class="fas fa-layer-group"></i>
                            Select con Grupos
                        </label>
                        <select class="form-control-modern" id="select_group">
                            <option value="">Seleccione una opción</option>
                            <optgroup label="Grupo 1">
                                <option value="1-1">Opción 1.1</option>
                                <option value="1-2">Opción 1.2</option>
                            </optgroup>
                            <optgroup label="Grupo 2">
                                <option value="2-1">Opción 2.1</option>
                                <option value="2-2">Opción 2.2</option>
                            </optgroup>
                        </select>
                    </div>

                    <!-- 15. SELECT MÚLTIPLE -->
                    <div class="form-group-modern">
                        <label for="select_multiple" class="form-label-modern">
                            <i class="fas fa-check-double"></i>
                            Select Múltiple
                        </label>
                        <select class="form-control-modern" id="select_multiple" multiple size="4">
                            <option value="1">Opción 1</option>
                            <option value="2">Opción 2</option>
                            <option value="3">Opción 3</option>
                            <option value="4">Opción 4</option>
                        </select>
                        <small class="form-text-modern">
                            <i class="fas fa-info-circle"></i>
                            Mantén Ctrl/Cmd para seleccionar múltiples opciones
                        </small>
                    </div>

                    <!-- 16. RADIO BUTTONS -->
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-dot-circle"></i>
                            Radio Buttons
                            <span class="required-badge">*</span>
                        </label>
                        <div class="radio-group-modern">
                            <label class="radio-modern">
                                <input type="radio" name="radio_example" value="1" checked>
                                <span class="radio-checkmark"></span>
                                <span class="radio-label">Opción 1</span>
                            </label>
                            <label class="radio-modern">
                                <input type="radio" name="radio_example" value="2">
                                <span class="radio-checkmark"></span>
                                <span class="radio-label">Opción 2</span>
                            </label>
                            <label class="radio-modern">
                                <input type="radio" name="radio_example" value="3">
                                <span class="radio-checkmark"></span>
                                <span class="radio-label">Opción 3</span>
                            </label>
                        </div>
                    </div>

                    <!-- 17. CHECKBOXES -->
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-check-square"></i>
                            Checkboxes
                        </label>
                        <div class="checkbox-group-modern">
                            <label class="checkbox-modern">
                                <input type="checkbox" value="1" checked>
                                <span class="checkbox-checkmark"></span>
                                <span class="checkbox-label">Opción A</span>
                            </label>
                            <label class="checkbox-modern">
                                <input type="checkbox" value="2">
                                <span class="checkbox-checkmark"></span>
                                <span class="checkbox-label">Opción B</span>
                            </label>
                            <label class="checkbox-modern">
                                <input type="checkbox" value="3" checked>
                                <span class="checkbox-checkmark"></span>
                                <span class="checkbox-label">Opción C</span>
                            </label>
                        </div>
                    </div>

                    <!-- 18. SWITCH TOGGLE -->
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-toggle-on"></i>
                            Switch Toggle
                        </label>
                        <div class="switch-group-modern">
                            <label class="switch-modern">
                                <input type="checkbox" checked>
                                <span class="switch-slider"></span>
                                <span class="switch-label">Activar notificaciones</span>
                            </label>
                            <label class="switch-modern">
                                <input type="checkbox">
                                <span class="switch-slider"></span>
                                <span class="switch-label">Modo oscuro</span>
                            </label>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <!-- CARD: ÁREAS DE TEXTO Y ARCHIVOS -->
        <div class="card-modern">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        <h3>Áreas de Texto y Archivos</h3>
                        <p>Campos de texto extensos y carga de archivos</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern">
                <form class="form-modern">
                    
                    <!-- 19. TEXTAREA -->
                    <div class="form-group-modern">
                        <label for="textarea" class="form-label-modern">
                            <i class="fas fa-align-left"></i>
                            Área de Texto
                            <span class="required-badge">*</span>
                        </label>
                        <textarea 
                            class="form-control-modern" 
                            id="textarea" 
                            rows="4" 
                            placeholder="Escriba su mensaje aquí..."></textarea>
                        <small class="form-text-modern">
                            <i class="fas fa-info-circle"></i>
                            Máximo 500 caracteres
                        </small>
                    </div>

                    <!-- 20. FILE UPLOAD SIMPLE -->
                    <div class="form-group-modern">
                        <label for="file_simple" class="form-label-modern">
                            <i class="fas fa-paperclip"></i>
                            Subir Archivo Simple
                        </label>
                        <input 
                            type="file" 
                            class="form-control-modern" 
                            id="file_simple">
                    </div>

                    <!-- 21. FILE UPLOAD PERSONALIZADO -->
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-cloud-upload-alt"></i>
                            Subir Archivo (Personalizado)
                        </label>
                        <div class="file-upload-modern">
                            <input type="file" id="file_custom" hidden>
                            <label for="file_custom" class="file-upload-label">
                                <div class="file-upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="file-upload-text">
                                    <strong>Haz clic para subir</strong>
                                    <span>o arrastra y suelta</span>
                                </div>
                                <div class="file-upload-info">
                                    PDF, DOC, DOCX hasta 10MB
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- 22. FILE UPLOAD MÚLTIPLE -->
                    <div class="form-group-modern">
                        <label for="file_multiple" class="form-label-modern">
                            <i class="fas fa-images"></i>
                            Subir Múltiples Archivos
                        </label>
                        <input 
                            type="file" 
                            class="form-control-modern" 
                            id="file_multiple"
                            multiple>
                        <small class="form-text-modern">
                            <i class="fas fa-info-circle"></i>
                            Puedes seleccionar varios archivos a la vez
                        </small>
                    </div>

                </form>
            </div>
        </div>

        <!-- CARD: CAMPOS ESPECIALES -->
        <div class="card-modern">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h3>Campos Especiales</h3>
                        <p>Rangos, colores y campos avanzados</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern">
                <form class="form-modern">
                    
                    <!-- 23. RANGE SLIDER -->
                    <div class="form-group-modern">
                        <label for="range" class="form-label-modern">
                            <i class="fas fa-sliders-h"></i>
                            Range Slider
                        </label>
                        <div class="range-container-modern">
                            <input 
                                type="range" 
                                class="range-modern" 
                                id="range" 
                                min="0" 
                                max="100" 
                                value="50"
                                oninput="document.getElementById('range_value').textContent = this.value">
                            <div class="range-value">
                                <span id="range_value">50</span>
                            </div>
                        </div>
                    </div>

                    <!-- 24. COLOR PICKER -->
                    <div class="form-row-modern">
                        <div class="form-group-modern">
                            <label for="color" class="form-label-modern">
                                <i class="fas fa-palette"></i>
                                Selector de Color
                            </label>
                            <div class="color-picker-modern">
                                <input 
                                    type="color" 
                                    class="color-input-modern" 
                                    id="color" 
                                    value="#4f46e5">
                                <input 
                                    type="text" 
                                    class="form-control-modern" 
                                    value="#4f46e5" 
                                    readonly>
                            </div>
                        </div>

                        <!-- 25. DATETIME LOCAL -->
                        <div class="form-group-modern">
                            <label for="datetime" class="form-label-modern">
                                <i class="fas fa-calendar-check"></i>
                                Fecha y Hora
                            </label>
                            <input 
                                type="datetime-local" 
                                class="form-control-modern" 
                                id="datetime">
                        </div>
                    </div>

                    <!-- 26. MONTH -->
                    <div class="form-row-modern">
                        <div class="form-group-modern">
                            <label for="month" class="form-label-modern">
                                <i class="fas fa-calendar-alt"></i>
                                Mes y Año
                            </label>
                            <input 
                                type="month" 
                                class="form-control-modern" 
                                id="month">
                        </div>

                        <!-- 27. WEEK -->
                        <div class="form-group-modern">
                            <label for="week" class="form-label-modern">
                                <i class="fas fa-calendar-week"></i>
                                Semana
                            </label>
                            <input 
                                type="week" 
                                class="form-control-modern" 
                                id="week">
                        </div>
                    </div>

                    <!-- 28. DATALIST (AUTOCOMPLETAR) -->
                    <div class="form-group-modern">
                        <label for="datalist" class="form-label-modern">
                            <i class="fas fa-list-ul"></i>
                            Campo con Autocompletado
                        </label>
                        <input 
                            type="text" 
                            class="form-control-modern" 
                            id="datalist"
                            list="suggestions"
                            placeholder="Escriba para ver sugerencias">
                        <datalist id="suggestions">
                            <option value="JavaScript">
                            <option value="Python">
                            <option value="Java">
                            <option value="C++">
                            <option value="PHP">
                        </datalist>
                    </div>

                </form>
            </div>
        </div>

        <!-- CARD: BOTONES -->
        <div class="card-modern">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-mouse-pointer"></i>
                    </div>
                    <div>
                        <h3>Botones</h3>
                        <p>Diferentes estilos de botones</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern">
                <div class="buttons-showcase">
                    <div class="button-group">
                        <h4>Botones Primarios</h4>
                        <button type="button" class="btn-primary-modern">
                            <i class="fas fa-save"></i>
                            Guardar
                        </button>
                        <button type="button" class="btn-primary-modern" disabled>
                            <i class="fas fa-save"></i>
                            Deshabilitado
                        </button>
                    </div>

                    <div class="button-group">
                        <h4>Botones Secundarios</h4>
                        <button type="button" class="btn-secondary-modern">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </button>
                        <button type="button" class="btn-secondary-modern" disabled>
                            <i class="fas fa-times"></i>
                            Deshabilitado
                        </button>
                    </div>

                    <div class="button-group">
                        <h4>Botones de Acción</h4>
                        <button type="button" class="btn-success-modern">
                            <i class="fas fa-check"></i>
                            Éxito
                        </button>
                        <button type="button" class="btn-danger-modern">
                            <i class="fas fa-trash"></i>
                            Eliminar
                        </button>
                        <button type="button" class="btn-warning-modern">
                            <i class="fas fa-exclamation-triangle"></i>
                            Advertencia
                        </button>
                        <button type="button" class="btn-info-modern">
                            <i class="fas fa-info-circle"></i>
                            Información
                        </button>
                    </div>

                    <div class="button-group">
                        <h4>Botones Outline</h4>
                        <button type="button" class="btn-outline-primary">
                            <i class="fas fa-eye"></i>
                            Ver
                        </button>
                        <button type="button" class="btn-outline-danger">
                            <i class="fas fa-trash"></i>
                            Eliminar
                        </button>
                    </div>

                    <div class="button-group">
                        <h4>Botones de Tamaño</h4>
                        <button type="button" class="btn-primary-modern btn-sm">
                            <i class="fas fa-save"></i>
                            Pequeño
                        </button>
                        <button type="button" class="btn-primary-modern">
                            <i class="fas fa-save"></i>
                            Normal
                        </button>
                        <button type="button" class="btn-primary-modern btn-lg">
                            <i class="fas fa-save"></i>
                            Grande
                        </button>
                    </div>

                    <div class="button-group">
                        <h4>Grupos de Botones</h4>
                        <div class="form-actions-modern">
                            <button type="button" class="btn-secondary-modern">
                                <i class="fas fa-undo"></i>
                                Limpiar
                            </button>
                            <button type="button" class="btn-primary-modern">
                                <i class="fas fa-save"></i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = event.currentTarget.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection
