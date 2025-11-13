/**
 * AJAX Pagination - Simple y Reutilizable
 * Solo maneja la paginación, NO interfiere con modales
 */

document.addEventListener('DOMContentLoaded', function () {
    const tableContainer = document.querySelector('#areaEstudioTable');
    
    if (!tableContainer) return;

    // Delegación de eventos para enlaces de paginación
    tableContainer.addEventListener('click', function(e) {
        // Verificar si es un enlace de paginación
        const paginationLink = e.target.closest('.pagination a');
        
        if (paginationLink) {
            e.preventDefault();
            e.stopPropagation();
            
            const url = paginationLink.getAttribute('href');
            if (!url) return;

            // Realizar petición AJAX
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Error en la petición');
                return response.text();
            })
            .then(html => {
                // IMPORTANTE: Destruir selectpickers existentes antes de reemplazar
                if (typeof $.fn.selectpicker !== 'undefined') {
                    $(tableContainer).find('.selectpicker').selectpicker('destroy');
                }

                // Reemplazar contenido de la tabla
                tableContainer.innerHTML = html;
                
                // Scroll suave hacia arriba de la tabla
                tableContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                
                // Re-inicializar selectpickers usando la función global
                if (typeof window.reinitSelectPickers === 'function') {
                    window.reinitSelectPickers(tableContainer);
                }
            })
            .catch(error => {
                console.error('Error en paginación AJAX:', error);
                // Fallback: navegar normalmente
                window.location.href = url;
            });
        }
    });
});