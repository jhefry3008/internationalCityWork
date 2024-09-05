



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
// Función para actualizar el total y los libros seleccionados
function updateTotalAndBooks() {
    let total = 0;
    const selectedBooks = [];

    document.querySelectorAll('.book-option.selected').forEach(button => {
        const price = parseFloat(button.getAttribute('data-price'));
        total += price;

        const bookTitle = button.getAttribute('data-title');
        const bookType = button.getAttribute('data-type');
        const bookEntry = `${bookTitle} (${bookType}) - $${price.toLocaleString('es-ES', { minimumFractionDigits: 0 })}`;

        if (!selectedBooks.includes(bookEntry)) {
            selectedBooks.push(bookEntry);
        }
    });

    document.getElementById('total').textContent = total.toLocaleString('es-ES', { minimumFractionDigits: 0 });
    localStorage.setItem('selectedBooks', JSON.stringify(selectedBooks));
    localStorage.setItem('totalToPay', total); // Guardar el total en localStorage
}

// Función para actualizar el total en el modal
function updateModalTotal() {
    const total = document.getElementById('total').textContent;
    document.getElementById('modal-total').textContent = total;
}

// Manejador de eventos para seleccionar y deseleccionar libros
document.querySelectorAll('.book-option').forEach(button => {
    button.addEventListener('click', function () {
        this.classList.toggle('selected');
        updateTotalAndBooks();
        document.getElementById('next-btn').disabled = false;
    });
});



// Manejador de eventos para mostrar el modal de pago
document.getElementById('next-btn').addEventListener('click', () => {
    updateModalTotal();
    new bootstrap.Modal(document.getElementById('payment-modal')).show();
});

// Manejador de eventos para seleccionar el método de pago
document.querySelectorAll('.payment-options img').forEach(icon => {
    icon.addEventListener('click', function () {
        // Quitar la clase 'active' de todas las opciones y añadirla a la seleccionada
        document.querySelectorAll('.payment-options img').forEach(i => i.classList.remove('active'));
        this.classList.add('active');
        
        // Guardar el método de pago seleccionado en localStorage
        localStorage.setItem('paymentMethod', this.id);
    });
});

// Manejador de eventos para redirigir a la página de pago seleccionada
document.getElementById('pay-btn').addEventListener('click', () => {
    let selectedPaymentMethod = document.querySelector('.payment-options img.active');
    if (selectedPaymentMethod) {
        // Actualizar el campo oculto en el formulario final
        document.getElementById('payment-method-form').value = selectedPaymentMethod.id;
        
        // Redirigir a la página de pago
        window.location.href = selectedPaymentMethod.getAttribute('data-link');
    } else {
        alert('Selecciona un método de pago');
    }
});


