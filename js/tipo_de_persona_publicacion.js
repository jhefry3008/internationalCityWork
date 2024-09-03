document.addEventListener('DOMContentLoaded', () => {
    const personTypeForm = document.getElementById('person-type-form');

    personTypeForm.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevenir el envío por defecto
        const selectedType = document.querySelector('input[name="person-type"]:checked').value;

        if (selectedType === 'natural') {
            window.location.href = '../formularios/persona_natural_form_publicacion.html'; 
        } else if (selectedType === 'juridica') {
            window.location.href = '../formularios/persona_juridica_form_publicacion.html'; 
        }
    });
});