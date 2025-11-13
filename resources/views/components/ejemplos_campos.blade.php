{{-- EJEMPLOS DE USO PARA TODOS LOS TIPOS DE INPUTS --}}

{{-- ========== INPUT TEXT ========== --}}
<div class="form-group-modern">
    <label for="nombre" class="form-label-modern">
        <i class="fas fa-user"></i>
        Nombre Completo
    </label>
    <input type="text" 
           name="nombre" 
           id="nombre" 
           class="form-control-modern" 
           placeholder="Ingrese el nombre completo"
           required>
    <div class="error-message" id="error_nombre">
        <i class="fas fa-exclamation-circle"></i>
        Este campo es obligatorio.
    </div>
</div>

{{-- ========== INPUT NUMBER ========== --}}
<div class="form-group-modern">
    <label for="edad" class="form-label-modern">
        <i class="fas fa-hashtag"></i>
        Edad
    </label>
    <input type="number" 
           name="edad" 
           id="edad" 
           class="form-control-modern" 
           placeholder="Ingrese la edad"
           min="0"
           max="120"
           required>
</div>

{{-- ========== INPUT DATE ========== --}}
<div class="form-group-modern">
    <label for="fecha_nacimiento" class="form-label-modern">
        <i class="fas fa-calendar-alt"></i>
        Fecha de Nacimiento
    </label>
    <input type="date" 
           name="fecha_nacimiento" 
           id="fecha_nacimiento" 
           class="form-control-modern"
           required>
</div>

{{-- ========== INPUT EMAIL ========== --}}
<div class="form-group-modern">
    <label for="email" class="form-label-modern">
        <i class="fas fa-envelope"></i>
        Correo Electrónico
    </label>
    <input type="email" 
           name="email" 
           id="email" 
           class="form-control-modern" 
           placeholder="correo@ejemplo.com"
           required>
</div>

{{-- ========== INPUT PHONE ========== --}}
<div class="form-group-modern">
    <label for="telefono" class="form-label-modern">
        <i class="fas fa-phone"></i>
        Teléfono
    </label>
    <input type="tel" 
           name="telefono" 
           id="telefono" 
           class="form-control-modern" 
           placeholder="0412-1234567"
           pattern="[0-9]{4}-[0-9]{7}"
           required>
</div>

{{-- ========== TEXTAREA ========== --}}
<div class="form-group-modern">
    <label for="descripcion" class="form-label-modern">
        <i class="fas fa-align-left"></i>
        Descripción
    </label>
    <textarea name="descripcion" 
              id="descripcion" 
              class="form-control-modern textarea-modern" 
              placeholder="Ingrese una descripción detallada"
              rows="4"></textarea>
</div>

{{-- ========== SELECT (Bootstrap Select) ========== --}}
<div class="form-group-modern">
    <label for="categoria" class="form-label-modern">
        <i class="fas fa-tags"></i>
        Categoría
    </label>
    <select name="categoria" 
            id="categoria" 
            class="form-control-modern selectpicker" 
            data-live-search="true"
            title="Seleccione una categoría"
            required>
        <option value="">Seleccione...</option>
        <option value="1">Categoría 1</option>
        <option value="2">Categoría 2</option>
        <option value="3">Categoría 3</option>
    </select>
</div>

{{-- ========== CHECKBOX (Individual) ========== --}}
<div class="form-group-modern">
    <label class="form-label-modern">
        <i class="fas fa-check-square"></i>
        Términos y Condiciones
    </label>
    <div class="form-check-modern">
        <input type="checkbox" 
               name="acepta_terminos" 
               id="acepta_terminos" 
               value="1"
               required>
        <label for="acepta_terminos">
            Acepto los términos y condiciones
        </label>
    </div>
</div>

{{-- ========== CHECKBOX (Múltiple) ========== --}}
<div class="form-group-modern">
    <label class="form-label-modern">
        <i class="fas fa-list-check"></i>
        Seleccione los días disponibles
    </label>
    <div class="form-check-group">
        <div class="form-check-modern">
            <input type="checkbox" name="dias[]" id="lunes" value="lunes">
            <label for="lunes">Lunes</label>
        </div>
        <div class="form-check-modern">
            <input type="checkbox" name="dias[]" id="martes" value="martes">
            <label for="martes">Martes</label>
        </div>
        <div class="form-check-modern">
            <input type="checkbox" name="dias[]" id="miercoles" value="miercoles">
            <label for="miercoles">Miércoles</label>
        </div>
    </div>
</div>

{{-- ========== RADIO BUTTONS ========== --}}
<div class="form-group-modern">
    <label class="form-label-modern">
        <i class="fas fa-circle-dot"></i>
        Género
    </label>
    <div class="form-check-group">
        <div class="form-check-modern">
            <input type="radio" name="genero" id="masculino" value="M" required>
            <label for="masculino">Masculino</label>
        </div>
        <div class="form-check-modern">
            <input type="radio" name="genero" id="femenino" value="F" required>
            <label for="femenino">Femenino</label>
        </div>
        <div class="form-check-modern">
            <input type="radio" name="genero" id="otro" value="O" required>
            <label for="otro">Otro</label>
        </div>
    </div>
</div>

{{-- ========== SWITCH/TOGGLE ========== --}}
<div class="form-group-modern">
    <label class="form-label-modern">
        <i class="fas fa-toggle-on"></i>
        Estado
    </label>
    <div class="switch-container">
        <label class="switch-modern">
            <input type="checkbox" name="status" id="status" value="1" checked>
            <span class="slider-modern"></span>
        </label>
        <label for="status" style="cursor: pointer; margin: 0;">
            Activar registro
        </label>
    </div>
</div>

{{-- ========== FILE UPLOAD ========== --}}
<div class="form-group-modern">
    <label class="form-label-modern">
        <i class="fas fa-cloud-upload-alt"></i>
        Subir Archivo
    </label>
    <div class="file-upload-modern">
        <input type="file" 
               name="archivo" 
               id="archivo" 
               accept=".pdf,.doc,.docx">
        <label for="archivo" class="file-upload-label">
            <div class="file-upload-icon">
                <i class="fas fa-file-upload"></i>
            </div>
            <div class="file-upload-text">
                <strong>Selecciona un archivo</strong>
                <small>PDF, DOC o DOCX (Máx. 5MB)</small>
            </div>
        </label>
    </div>
</div>

{{-- ========== INPUT DISABLED ========== --}}
<div class="form-group-modern">
    <label for="codigo" class="form-label-modern">
        <i class="fas fa-barcode"></i>
        Código (Generado automáticamente)
    </label>
    <input type="text" 
           name="codigo" 
           id="codigo" 
           class="form-control-modern" 
           value="AUT-2024-001"
           disabled>
</div>

{{-- ========== INPUT CON ICONO INTERNO ========== --}}
<div class="form-group-modern">
    <label for="buscar" class="form-label-modern">
        <i class="fas fa-search"></i>
        Búsqueda
    </label>
    <div style="position: relative;">
        <input type="text" 
               name="buscar" 
               id="buscar" 
               class="form-control-modern" 
               placeholder="Buscar..."
               style="padding-left: 2.5rem;">
        <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--gray-300);"></i>
    </div>
</div>

{{-- ========== INPUT RANGE ========== --}}
<div class="form-group-modern">
    <label for="rango" class="form-label-modern">
        <i class="fas fa-sliders-h"></i>
        Nivel de Prioridad
    </label>
    <input type="range" 
           name="prioridad" 
           id="rango" 
           class="form-control-modern" 
           min="1" 
           max="10" 
           value="5"
           style="padding: 0.5rem;">
    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--gray-700); margin-top: 0.5rem;">
        <span>Baja (1)</span>
        <span>Media (5)</span>
        <span>Alta (10)</span>
    </div>
</div>

{{-- ========== INPUT COLOR ========== --}}
<div class="form-group-modern">
    <label for="color" class="form-label-modern">
        <i class="fas fa-palette"></i>
        Color de Etiqueta
    </label>
    <input type="color" 
           name="color" 
           id="color" 
           class="form-control-modern" 
           value="#4f46e5"
           style="height: 50px; cursor: pointer;">
</div>