document.addEventListener('DOMContentLoaded', () => {
    // Selecciona los elementos para el formulario de Persona Jurídica
    const dataAuthorizationJuridicaCheckbox = document.getElementById('data-authorization-juridica');
    const paymentSectionJuridica = document.getElementById('payment-section-juridica');
    const submitButtonJuridica = document.getElementById('submit-button-juridica');
    const juridicaService = document.getElementById('juridica-service');
    
    // Maneja el cambio en el checkbox de autorización de datos para Persona Jurídica
    if (dataAuthorizationJuridicaCheckbox) {
        dataAuthorizationJuridicaCheckbox.addEventListener('change', (event) => {
            handleCheckboxChange(event.target, paymentSectionJuridica, submitButtonJuridica, juridicaService);
        });
    }

    function handleCheckboxChange(checkbox, paymentSection, submitButton, serviceSelect) {
        if (checkbox.checked) {
            submitButton.style.display = 'block';
            paymentSection.style.display = serviceSelect.value === 'publicaciones' ? 'block' : 'none';
        } else {
            submitButton.style.display = 'none';
            paymentSection.style.display = 'none';
        }
    }

    // Lógica para manejar el estado inicial en caso de que ya haya una selección
    if (dataAuthorizationJuridicaCheckbox && dataAuthorizationJuridicaCheckbox.checked) {
        handleCheckboxChange(dataAuthorizationJuridicaCheckbox, paymentSectionJuridica, submitButtonJuridica, juridicaService);
    }

    // Manejo del formulario de Persona Jurídica
    document.getElementById("juridica-form").addEventListener("submit", function(event) {
        event.preventDefault();

        // Obtener los valores del formulario
        const formData = {
            servicio: document.getElementById("juridica-service").value,
            empresa: document.getElementById("company-name").value,
            nit: document.getElementById("nit").value,
            direccion: document.getElementById("address-juridica").value,
            ciudad: document.getElementById("city-juridica").value,
            telefono: document.getElementById("phone-juridica").value,
            correo: document.getElementById("email-juridica").value,
            mensaje: document.getElementById("message-juridica").value,
            autorizacion: document.getElementById("data-authorization-juridica").checked
        };

        // Verificar que todos los campos obligatorios estén llenos
        for (const key in formData) {
            if (!formData[key] && key !== 'autorizacion') {
                alert(`El campo ${key} es obligatorio.`);
                return;
            }
        }

        localStorage.setItem("formType", "juridica");

        // Guardar los datos en localStorage
        localStorage.setItem("formDataJuridica", JSON.stringify(formData));

        alert("Datos guardados con éxito!");

        // Redirigir a la página de pagos o formulario final
        if (formData.servicio === "publicaciones") {
            window.location.href = "../pagos/pagos_libros.html";
        } else {
            window.location.href = "../formularios/formulariofinal-juridica.html";
        }
    });
});
