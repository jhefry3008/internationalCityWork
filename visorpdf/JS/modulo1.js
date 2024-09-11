const zoomButton = document.getElementById('zoom');
const currentPage = document.getElementById('current_page');
const viewer = document.querySelector('.pdf-viewer');
let currentPDF = {};

// URL del archivo PDF predeterminado
const defaultPDFURL = 'pdf/MODULO1.pdf'; 

function resetCurrentPDF() {
    currentPDF = {
        file: null,
        countOfPages: 0,
        currentPage: 1,
        zoom: 1.0
    }
}

function loadPDF(data) {
    const pdfFile = pdfjsLib.getDocument(data);
    resetCurrentPDF();
    pdfFile.promise.then((doc) => {
        currentPDF.file = doc;
        currentPDF.countOfPages = doc.numPages;
        viewer.classList.remove('hidden');
        document.querySelector('main h3').classList.add("hidden");
        renderCurrentPage();
    });
}

function renderCurrentPage() {
    currentPDF.file.getPage(currentPDF.currentPage).then((page) => {
        const scale = currentPDF.zoom;
        const viewport = page.getViewport({ scale });

        // Ajustar el tamaño del canvas según el tamaño disponible
        const canvasContainerWidth = viewer.parentElement.clientWidth;
        const scaleRatio = canvasContainerWidth / viewport.width;
        const adjustedViewport = page.getViewport({ scale: scale * scaleRatio });

        var context = viewer.getContext('2d');
        viewer.height = adjustedViewport.height;
        viewer.width = adjustedViewport.width;

        var renderContext = {
            canvasContext: context,
            viewport: adjustedViewport
        };

        page.render(renderContext);
    });

    currentPage.innerHTML = `${currentPDF.currentPage} of ${currentPDF.countOfPages}`;
}

// Cargar el PDF predeterminado al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    loadPDF(defaultPDFURL);
});

// Funcionalidad del zoom
zoomButton.addEventListener('input', () => {
    if (currentPDF.file) {
        document.getElementById('zoomValue').innerHTML = zoomButton.value + "%";
        currentPDF.zoom = parseInt(zoomButton.value) / 100;
        renderCurrentPage();
    }
});

// Navegación entre páginas
document.getElementById('next').addEventListener('click', () => {
    const isValidPage = currentPDF.currentPage < currentPDF.countOfPages;
    if (isValidPage) {
        currentPDF.currentPage += 1;
        renderCurrentPage();
    }
});

document.getElementById('previous').addEventListener('click', () => {
    const isValidPage = currentPDF.currentPage - 1 > 0;
    if (isValidPage) {
        currentPDF.currentPage -= 1;
        renderCurrentPage();
    }
});

window.onbeforeprint = function() {
    alert("La opción de imprimir está deshabilitada.");
    return false; // Impide la impresión.
};

document.addEventListener('keydown', function (e) {
    if (e.ctrlKey && e.key === 'p') {
        e.preventDefault();
        alert('La opción de imprimir está deshabilitada.');
    }
});

document.addEventListener('contextmenu', function (e) {
    e.preventDefault();
});