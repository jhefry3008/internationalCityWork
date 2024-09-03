document.addEventListener('DOMContentLoaded', () => {
    // Selecciona los elementos para ambos formularios
    const dataAuthorizationNaturalCheckbox = document.getElementById('data-authorization-natural');
    const paymentSectionNatural = document.getElementById('payment-section-natural');
    const submitButtonNatural = document.getElementById('submit-button-natural');
    const naturalService = document.getElementById('natural-service');
    
    const dataAuthorizationJuridicaCheckbox = document.getElementById('data-authorization-juridica');
    const paymentSectionJuridica = document.getElementById('payment-section-juridica');
    const submitButtonJuridica = document.getElementById('submit-button-juridica');
    const juridicaService = document.getElementById('juridica-service');

    // Maneja el cambio en el checkbox de autorización de datos para Persona Natural
    if (dataAuthorizationNaturalCheckbox) {
        dataAuthorizationNaturalCheckbox.addEventListener('change', (event) => {
            handleCheckboxChange(event.target, paymentSectionNatural, submitButtonNatural, naturalService);
        });
    }

    // Maneja el cambio en el checkbox de autorización de datos para Persona Jurídica
    if (dataAuthorizationJuridicaCheckbox) {
        dataAuthorizationJuridicaCheckbox.addEventListener('change', (event) => {
            handleCheckboxChange(event.target, paymentSectionJuridica, submitButtonJuridica, juridicaService);
        });
    }

    function handleCheckboxChange(checkbox, paymentSection, submitButton, serviceSelect) {
        if (checkbox.checked) {
            submitButton.style.display = 'block';
            if (serviceSelect.value === 'publicaciones') {
                paymentSection.style.display = 'block';
            } else {
                paymentSection.style.display = 'none';
            }
        } else {
            submitButton.style.display = 'none';
            paymentSection.style.display = 'none';
        }
    }

    function handleServiceChange(serviceSelect, paymentSection, checkbox) {
        if (checkbox.checked && serviceSelect.value === 'publicaciones') {
            paymentSection.style.display = 'block';
        } else {
            paymentSection.style.display = 'none';
        }
    }

    // Lógica para manejar el estado inicial en caso de que ya haya una selección
    const initialDataAuthorizationNatural = dataAuthorizationNaturalCheckbox && dataAuthorizationNaturalCheckbox.checked;
    if (initialDataAuthorizationNatural) {
        handleCheckboxChange(dataAuthorizationNaturalCheckbox, paymentSectionNatural, submitButtonNatural, naturalService);
    }

    const initialDataAuthorizationJuridica = dataAuthorizationJuridicaCheckbox && dataAuthorizationJuridicaCheckbox.checked;
    if (initialDataAuthorizationJuridica) {
        handleCheckboxChange(dataAuthorizationJuridicaCheckbox, paymentSectionJuridica, submitButtonJuridica, juridicaService);
    }
});