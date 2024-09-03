document.addEventListener("DOMContentLoaded", function() {
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

    // Recuperar los datos del localStorage para el formulario de Persona Natural
    const savedDataNatural = JSON.parse(localStorage.getItem("formDataNatural"));
    if (savedDataNatural) {
        document.getElementById("natural-service").value = savedDataNatural.servicio || "";
        document.getElementById("document-type").value = savedDataNatural.documento || "";
        document.getElementById("full-name-natural").value = savedDataNatural.nombre || "";
        document.getElementById("address-natural").value = savedDataNatural.direccion || "";
        document.getElementById("city-natural").value = savedDataNatural.ciudad || "";
        document.getElementById("phone-natural").value = savedDataNatural.telefono || "";
        document.getElementById("email-natural").value = savedDataNatural.correo || "";
        document.getElementById("message-natural").value = savedDataNatural.mensaje || "";
        document.getElementById("data-authorization-natural").checked = savedDataNatural.autorizacion || false;
    }

    // Configurar el evento de envío para el formulario de Persona Jurídica
    const juridicaForm = document.getElementById("juridica-form");
    if (juridicaForm) {
        juridicaForm.addEventListener("submit", function(event) {
            event.preventDefault();
            // Guardar el tipo de formulario en el localStorage
            localStorage.setItem("formType", "juridica");
            // Resto del código de procesamiento del formulario...
        });
    }

    // Configurar el evento de envío para el formulario de Persona Natural
    const naturalForm = document.getElementById("natural-form");
    if (naturalForm) {
        naturalForm.addEventListener("submit", function(event) {
            event.preventDefault();
            // Guardar el tipo de formulario en el localStorage
            localStorage.setItem("formType", "natural");
            // Resto del código de procesamiento del formulario...
        });
    }
});
