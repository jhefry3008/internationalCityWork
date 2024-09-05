document.addEventListener("DOMContentLoaded", function() {
    // Recuperar los datos del localStorage para el formulario de Persona Natural
    const savedDataNatural = JSON.parse(localStorage.getItem("formDataNatural"));
    
    if (savedDataNatural) {
        // Completar los campos del formulario
        document.getElementById("natural-service").value = savedDataNatural.servicio || "";
        document.getElementById("document-type").value = savedDataNatural.documento || "";
        document.getElementById("numero-documento").value = savedDataNatural.numero || "";
        document.getElementById("full-name-natural").value = savedDataNatural.nombre || "";
        document.getElementById("address-natural").value = savedDataNatural.direccion || "";
        document.getElementById("city-natural").value = savedDataNatural.ciudad || "";
        document.getElementById("phone-natural").value = savedDataNatural.telefono || "";
        document.getElementById("email-natural").value = savedDataNatural.correo || "";
        document.getElementById("message-natural").value = savedDataNatural.mensaje || "";
        document.getElementById("data-authorization-natural").checked = savedDataNatural.autorizacion || false;
    }

    // Recuperar los libros seleccionados
    const savedBooks = JSON.parse(localStorage.getItem("selectedBooks")) || [];
    const booksList = document.getElementById("libros-seleccionados-list");
    const booksHiddenInput = document.getElementById("libros-seleccionados");

    booksList.innerHTML = ''; // Limpiar lista antes de agregar elementos
    savedBooks.forEach(book => {
        const listItem = document.createElement("li");
        listItem.textContent = book;
        booksList.appendChild(listItem);
    });

    // Guardar los libros seleccionados en el campo oculto
    booksHiddenInput.value = savedBooks.join(", ");

    // Recuperar el total a pagar y método de pago
    const totalToPay = localStorage.getItem("totalToPay") || "0.00";
    const paymentMethod = localStorage.getItem("paymentMethod") || "No especificado";

    // Mostrar el total y el método de pago en el formulario
    const totalDisplay = document.createElement("p");
    totalDisplay.textContent = `Total a pagar: $${totalToPay}`;
    document.getElementById("libros-seleccionados-container").appendChild(totalDisplay);

    const paymentMethodDisplay = document.createElement("p");
    paymentMethodDisplay.textContent = `Método de pago: ${paymentMethod}`;
    document.getElementById("libros-seleccionados-container").appendChild(paymentMethodDisplay);

    // Guardar el total a pagar y el método de pago en los campos ocultos
    document.getElementById('total-to-pay-natural').value = totalToPay;
    document.getElementById('payment-method-form-natural').value = paymentMethod;
});
