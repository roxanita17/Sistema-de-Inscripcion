# MODULO: INSCRIPCIÓN

## BACKEND / REGLAS DE NEGOCIO (BK)
Falta:

### Validaciones

### Lógica de inscripción
6. Filtrar institución de procedencia por:
   - País
   - Estado
   - Municipio
   - Localidad

## Funcionalidades
Falta:

1. Implementar buscadores con Livewire en los selects de inscripción
2. Implementar buscadores con Livewire en los index
3. Editar inscripción
4. Inscripción por prosecución (tipo de inscripción)

## Filtros
Falta:
1. Filtro por status de inscripción
2. Filtro por grado
   - Inscripción
   - Historial de percentil
3. Filtro por sección
   - Inscripción
   - Historial de percentil

--------------------------------------------------------------------------

## SEEDERS
Falta:

1. Acomodar seeder de materias según el pensum
2. Crear seeder de estados (incluyendo dependencias federales)
3. Mejorar seeder de alumnos e inscripción
4. Acomodar seeder de representantes

--------------------------------------------------------------------------

# MODULO: HISTÓRICO ACADÉMICO

## FILTRADO
Falta:

### Inscripción
2. Filtrar por grado
3. Filtrar por sección

### Docente (docente_area_grado)
4. Filtrar por materias
5. Filtrar por grado


--------------------------------------------------------------------------

# BASE DE DATOS (BD)

Falta:

1. Separar las tallas del estudiante en una tabla independiente
2. Modelar correctamente el tipo de inscripción
3. Crear nuevas migraciones necesarias
4. Conectar las nuevas migraciones con los módulos ya existentes
5. Agregar la tabla de Grupos estables
6. Verificar el modelado con la bd real del sistema

--------------------------------------------------------------------------

# MODULO: AREA DE FORMACION

### Logica del codigo
1. Rehacer la logica del codigo según el pensum

--------------------------------------------------------------------------

# MODULO: DOCENTE AREA GRADO

### Validaciones
1. Validar que no se asignen materias duplicadas a un docente en el mismo grado
2. Validar que las materias y grados que esten disponibles sean las mismas registradas en GRADO AREA FORMACION
3. Deshabilitar la opcion de asignar materias si no esta ejecutado el percentil

### Agregar
2. Registro de grupos estables

--------------------------------------------------------------------------

# TODOS LOS MODULOS

Falta:
1. Agregar nuevo diseño de botones en todas las tablas-


# MODULOS EN PROCESO / FALTANTES

2. Inscripción por prosecución
3. Asignación de materias a estudios
   - Ajustar según punto de control 2 (opcional)
4. Módulo para la información de la comunidad
5. Materias pendientes
   - BD y lógica
   - Actualizar estados de materias (opcional)
6. Advertencia al eliminar una materia relacionada con un docente
7. Edición avanzada de inscripción
