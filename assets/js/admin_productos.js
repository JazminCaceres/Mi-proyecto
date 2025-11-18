/* admin-productos.js
 * Funcionalidades para la gestión de productos en el panel de administración
 */

/**
 * Confirmar eliminación de producto
 * @param {Event} event - Evento del click
 * @returns {boolean} - false para prevenir navegación si se cancela
 */
function confirmDelete(event) {
    event.preventDefault();
    
    const link = event.currentTarget;
    const productId = new URL(link.href).searchParams.get('id');
    
    // Mostrar confirmación
    const confirmed = confirm('¿Estás seguro de que deseas eliminar este producto?\n\nEsta acción no se puede deshacer.');
    
    if (confirmed) {
        // Opcional: mostrar un indicador de carga
        const originalText = link.innerHTML;
        link.innerHTML = '⏳ Eliminando...';
        link.style.pointerEvents = 'none';
        
        // Redirigir a la página de eliminación
        window.location.href = link.href;
    }
    
    return false;
}

/**
 * Mostrar mensaje de éxito o error después de eliminar
 */
function showDeleteMessage() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.has('deleted')) {
        showNotification('✅ Producto eliminado exitosamente', 'success');
        // Limpiar el parámetro de la URL sin recargar
        window.history.replaceState({}, document.title, 'productos.php');
    } else if (urlParams.has('error')) {
        showNotification('❌ Error al eliminar el producto. Inténtalo de nuevo.', 'error');
        window.history.replaceState({}, document.title, 'productos.php');
    }
}

/**
 * Mostrar notificación temporal
 * @param {string} message - Mensaje a mostrar
 * @param {string} type - Tipo de notificación ('success' o 'error')
 */
function showNotification(message, type = 'info') {
    // Crear elemento de notificación
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Estilos inline (puedes moverlos a tu CSS)
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background: ${type === 'success' ? '#4caf50' : '#f44336'};
        color: white;
        border-radius: 4px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        z-index: 10000;
        animation: slideIn 0.3s ease-out;
        font-size: 14px;
        max-width: 300px;
    `;
    
    document.body.appendChild(notification);
    
    // Remover después de 3 segundos
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

/**
 * Validar imagen al cargar
 * Muestra placeholder si la imagen falla
 */
function handleImageError(img) {
    img.style.display = 'none';
    if (img.nextElementSibling) {
        img.nextElementSibling.style.display = 'flex';
    }
}

/**
 * Previsualización de búsqueda en tiempo real (opcional)
 */
function setupLiveSearch() {
    const searchInput = document.querySelector('input[name="search"]');
    if (!searchInput) return;
    
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        
        // Esperar 500ms después de que el usuario deje de escribir
        searchTimeout = setTimeout(() => {
            if (this.value.length >= 3 || this.value.length === 0) {
                this.form.submit();
            }
        }, 500);
    });
}

/**
 * Agregar animaciones a la tabla
 */
function animateTableRows() {
    const rows = document.querySelectorAll('.appointments-table tbody tr');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease-out';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 50);
    });
}

/**
 * Inicializar cuando el DOM esté listo
 */
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar mensaje si hay parámetros en la URL
    showDeleteMessage();
    
    // Configurar búsqueda en tiempo real (opcional, descomenta si quieres)
    // setupLiveSearch();
    
    // Animar filas de la tabla (opcional)
    // animateTableRows();
    
    console.log('🎨 Admin Productos JS cargado correctamente');
});

// Agregar estilos de animación al head
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);