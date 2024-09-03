// Función para mostrar el modal con el total actualizado
document.getElementById('next-btn').addEventListener('click', function() {
    // Actualiza el total en el modal
    var total = document.getElementById('total').textContent;
    document.getElementById('modalTotal').textContent = total;

    // Muestra el modal
    var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    paymentModal.show();
});

// Manejo de selección de método de pago
document.querySelectorAll('.payment-method').forEach(function(element) {
    element.addEventListener('click', function() {
        var link = this.getAttribute('data-link');
        document.getElementById('modalPayBtn').setAttribute('data-link', link);
    });
});

// Manejo del botón de pago en el modal
document.getElementById('modalPayBtn').addEventListener('click', function() {
    var link = this.getAttribute('data-link');
    if (link) {
        window.location.href = link;
    }
});
