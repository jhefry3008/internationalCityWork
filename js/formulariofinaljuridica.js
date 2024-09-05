document.addEventListener("DOMContentLoaded", function () {
    // Recuperar los datos del localStorage para el formulario de Persona Jurídica
    const savedDataJuridica = JSON.parse(localStorage.getItem("formDataJuridica"));
    if (savedDataJuridica) {
        document.getElementById("juridica-service").value = savedDataJuridica.servicio || "";
        document.getElementById("company-name").value = savedDataJuridica.empresa || "";
        document.getElementById("nit").value = savedDataJuridica.nit || "";
        document.getElementById("address-juridica").value = savedDataJuridica.direccion || "";
        document.getElementById("city-juridica").value = savedDataJuridica.ciudad || "";
        document.getElementById("phone-juridica").value = savedDataJuridica.telefono || "";
        document.getElementById("email-juridica").value = savedDataJuridica.correo || "";
        document.getElementById("message-juridica").value = savedDataJuridica.mensaje || "";
        document.getElementById("data-authorization-juridica").checked = savedDataJuridica.autorizacion || false;
    }

   // Recuperar los datos de los libros seleccionados y mostrarlos en el formulario
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


// Recuperar el total a pagar y mostrarlo en el formulario
const totalToPay = localStorage.getItem("totalToPay") || "0.00";
const totalDisplay = document.createElement("p");
totalDisplay.textContent = `Total a pagar: $${totalToPay}`;
document.getElementById("libros-seleccionados-container").appendChild(totalDisplay);
   // Recuperar y mostrar el método de pago
   const paymentMethod = localStorage.getItem("paymentMethod") || "No especificado";
   const paymentMethodDisplay = document.createElement("p");
   paymentMethodDisplay.textContent = `Método de pago: ${paymentMethod}`;
   document.getElementById("libros-seleccionados-container").appendChild(paymentMethodDisplay);
 


// Configurar el evento de envío para el formulario de Persona Jurídica
const juridicaForm = document.getElementById("juridica-final-form");
if (naturalForm) {
    naturalForm.addEventListener("submit", function (event) {
        event.preventDefault();
        // Guardar el tipo de formulario en el localStorage
        localStorage.setItem("formType", "juridica");
        // Enviar el formulario o realizar otras acciones necesarias...
        // Puedes descomentar y usar el siguiente código si deseas enviar el formulario automáticamente
        // juridicaForm.submit();
    });
};
});

// Función para actualizar el total y el método de pago en el formulario
function updateTotalAndPayment() {
    const total = localStorage.getItem('totalToPay') || "0.00";
    const paymentMethod = localStorage.getItem('paymentMethod') || "No seleccionado";

    // Asegúrate de que el ID coincida con el campo oculto en el HTML
    document.getElementById('total-to-pay').value = total;
    document.getElementById('payment-method-form').value = paymentMethod;
    
    // Opcional: si quieres mostrar el total y el método de pago en la página de manera visible
    document.getElementById('total-to-pay-display').textContent = `$${total}`;
    document.getElementById('payment-method-display').textContent = paymentMethod;
}

// Llamar a la función cuando se carga la página
document.addEventListener("DOMContentLoaded", updateTotalAndPayment);


