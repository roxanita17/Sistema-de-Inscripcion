# MODULO: INSCRIPCIÓN

## BACKEND / REGLAS DE NEGOCIO (BK)
Falta:

### Validaciones críticas
1. Validar que el percentil solo se ejecute una vez por inscripción o reescriba los datos

### Lógica de inscripción
5. Al crear representante desde inscripción:
   - Al volver o cancelar debe regresar a la inscripción
6. Filtrar institución de procedencia por:
   - País
   - Estado
   - Municipio
   - Localidad

---

## FUNCIONALIDADES
Falta:

1. Implementar buscadores con Livewire en los selects de inscripción
2. Implementar buscadores con Livewire en los index
3. Editar inscripción
4. Inscripción por prosecución (tipo de inscripción)

---

## FILTROS
Falta:

1. Filtro por status de inscripción
2. Filtro por grado
   - Inscripción
   - Historial de percentil
3. Filtro por sección
   - Inscripción
   - Historial de percentil

---

## DISEÑO / VISTAS (FRONTEND)
Falta:

3. Mejorar vista del historial de percentil

---

## SEEDERS
Falta:

1. Acomodar seeder de materias según el pensum
2. Crear seeder de estados (incluyendo dependencias federales)
3. Mejorar seeder de alumnos e inscripción
4. Acomodar seeder de representantes

# MODULO: HISTÓRICO ACADÉMICO

## FILTRADO
Falta:

### Inscripción
1. Filtrar por tipo de inscripción
2. Filtrar por grado
3. Filtrar por sección
4. Filtrar por institución de procedencia

### Docente (docente_area_grado)
5. Filtrar por materias
6. Filtrar por estudios del docente
7. Filtrar por grado
8. Filtrar por sección

### Percentil
9. Historial del percentil (entradas_percentil)


# BASE DE DATOS (BD)

## INSCRIPCIÓN
Falta:

1. Separar las tallas del estudiante en una tabla independiente
2. Modelar correctamente el tipo de inscripción
3. Crear nuevas migraciones necesarias
4. Conectar las nuevas migraciones con los módulos ya existentes

# MODULOS EN PROCESO / FALTANTES

1. Histórico por año escolar
2. Inscripción por prosecución
3. Asignación de materias a estudios
   - Ajustar según punto de control 2 (opcional)
4. Módulo para la información de la comunidad
5. Materias pendientes
   - BD y lógica
   - Actualizar estados de materias (opcional)
6. Advertencia al eliminar una materia relacionada con un docente
7. Edición avanzada de inscripción
