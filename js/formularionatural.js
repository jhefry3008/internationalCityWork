document.addEventListener('DOMContentLoaded', () => {
    // Selecciona los elementos para el formulario de Persona Natural
    const dataAuthorizationNaturalCheckbox = document.getElementById('data-authorization-natural');
    const paymentSectionNatural = document.getElementById('payment-section-natural');
    const submitButtonNatural = document.getElementById('submit-button-natural');
    const naturalService = document.getElementById('natural-service');

    // Maneja el cambio en el checkbox de autorización de datos para Persona Natural
    if (dataAuthorizationNaturalCheckbox) {
        dataAuthorizationNaturalCheckbox.addEventListener('change', (event) => {
            handleCheckboxChange(event.target, paymentSectionNatural, submitButtonNatural, naturalService);
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
    if (dataAuthorizationNaturalCheckbox && dataAuthorizationNaturalCheckbox.checked) {
        handleCheckboxChange(dataAuthorizationNaturalCheckbox, paymentSectionNatural, submitButtonNatural, naturalService);
    }

    // Manejo del formulario de Persona Natural
    document.getElementById("natural-form").addEventListener("submit", function(event) {
        event.preventDefault();

        // Validación de datos
        const servicio = document.getElementById("natural-service").value;
        if (!servicio) {
            alert("Por favor, seleccione un servicio.");
            return;
        }

        const formData = {
            servicio: document.getElementById("natural-service").value,
            documento: document.getElementById("document-type").value, // Correcto
            numero: document.getElementById("numero-documento").value, // Correcto
            nombre: document.getElementById("full-name-natural").value, // Correcto
            direccion: document.getElementById("address-natural").value,
            ciudad: document.getElementById("city-natural").value,
            telefono: document.getElementById("phone-natural").value,
            correo: document.getElementById("email-natural").value,
            mensaje: document.getElementById("message-natural").value,
            autorizacion: document.getElementById("data-authorization-natural").checked
        };

        // Verificar que todos los campos obligatorios estén llenos
        for (const key in formData) {
            if (!formData[key] && key !== 'autorizacion') {
                alert(`El campo ${key} es obligatorio.`);
                return;
            }
        }

        // Guardar los datos en localStorage
        localStorage.setItem("formDataNatural", JSON.stringify(formData));
        localStorage.setItem("formType", "natural");

        alert("Datos guardados con éxito!");

        // Redirigir a la página de pagos o formulario final
        console.log("Servicio seleccionado para redirección:", formData.servicio); // Para depuración
        if (formData.servicio === "publicaciones") {
            window.location.href = "../pagos/pagos_libros.html";
        } else {
            window.location.href = "../formularios/formulariofinal-natural.html";
        }
    });

    // Cargar datos guardados si existen
    const savedDataNatural = JSON.parse(localStorage.getItem("formDataNatural"));
    if (savedDataNatural) {
        document.getElementById("natural-service").value = savedDataNatural.servicio || "";
        document.getElementById("document-type").value = savedDataNatural.documento || ""; // Correcto
        document.getElementById("numero-documento").value = savedDataNatural.numero || ""; // Correcto
        document.getElementById("full-name-natural").value = savedDataNatural.nombre || ""; // Correcto
        document.getElementById("address-natural").value = savedDataNatural.direccion || "";
        document.getElementById("city-natural").value = savedDataNatural.ciudad || "";
        document.getElementById("phone-natural").value = savedDataNatural.telefono || "";
        document.getElementById("email-natural").value = savedDataNatural.correo || "";
        document.getElementById("message-natural").value = savedDataNatural.mensaje || "";
        document.getElementById("data-authorization-natural").checked = savedDataNatural.autorizacion || false;

        // Si la autorización ya estaba seleccionada, muestra las secciones correspondientes
        if (dataAuthorizationNaturalCheckbox.checked) {
            handleCheckboxChange(dataAuthorizationNaturalCheckbox, paymentSectionNatural, submitButtonNatural, naturalService);
        }
    }
});

