document.addEventListener("DOMContentLoaded", function() {
    // Recuperar los datos del localStorage para el formulario de Persona Natural
    const savedDataNatural = JSON.parse(localStorage.getItem("formDataNatural"));
    
    if (savedDataNatural) {
        // Completar los campos del formulario
        document.getElementById("natural-service").value = savedDataNatural.servicio || "";
        document.getElementById("document-type").value = savedDataNatural.documento || ""; // Aquí
        document.getElementById("numero-documento").value = savedDataNatural.numero || ""; // Aquí
        document.getElementById("full-name-natural").value = savedDataNatural.nombre || ""; // Aquí
        document.getElementById("address-natural").value = savedDataNatural.direccion || "";
        document.getElementById("city-natural").value = savedDataNatural.ciudad || "";
        document.getElementById("phone-natural").value = savedDataNatural.telefono || "";
        document.getElementById("email-natural").value = savedDataNatural.correo || "";
        document.getElementById("message-natural").value = savedDataNatural.mensaje || "";
        document.getElementById("data-authorization-natural").checked = savedDataNatural.autorizacion || false;
    }
});
