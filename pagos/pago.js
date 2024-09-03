function updateTotal() {
    let total = 0;
    document.querySelectorAll('.book-option.selected').forEach(button => {
        total += parseFloat(button.getAttribute('data-price'));
    });
    // Formatear el total con separadores de miles
    document.getElementById('total').textContent = total.toLocaleString('es-ES', { minimumFractionDigits: 0 });
}

// Manejador de eventos para los botones de opciones de libros
document.querySelectorAll('.book-option').forEach(button => {
    button.addEventListener('click', function () {
        // Alternar selección del botón
        this.classList.toggle('selected');
        updateTotal();
        document.getElementById('next-btn').disabled = false;
    });
});

// Manejador de eventos para mostrar las opciones de pago al hacer clic en "Siguiente"
document.getElementById('next-btn').addEventListener('click', () => {
    showPaymentOptions(); // Asegura que las imágenes se muestren
    updateModalTotal(); // Actualiza el total en el modal
    $('#payment-modal').modal('show');
});

// Función para mostrar las opciones de pago
function showPaymentOptions() {
    document.querySelectorAll('.payment-options img').forEach(img => {
        img.style.display = 'block'; // Asegúrate de que las imágenes estén visibles
    });
}

// Función para actualizar el total en el modal
function updateModalTotal() {
    const total = document.getElementById('total').textContent;
    document.getElementById('modal-total').textContent = total;
}

// Manejador de eventos para redirigir a la página de pago seleccionada
document.getElementById('pay-btn').addEventListener('click', () => {
    let selectedPaymentMethod = document.querySelector('.payment-options img.active');
    if (selectedPaymentMethod) {
        window.location.href = selectedPaymentMethod.getAttribute('data-link');
    } else {
        alert('Selecciona un método de pago');
    }
});

// Manejador de eventos para seleccionar el método de pago
document.querySelectorAll('.payment-options img').forEach(icon => {
    icon.addEventListener('click', function () {
        document.querySelectorAll('.payment-options img').forEach(i => i.classList.remove('active'));
        this.classList.add('active');
    });
});
