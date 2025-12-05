function initSlider(rangeId, minId, maxId, precioId) {
    const slider = document.getElementById(rangeId);
    const minInput = document.getElementById(minId);
    const maxInput = document.getElementById(maxId);
    const precioActual = document.getElementById(precioId);

    function actualizarPrecio() {
        const min = parseFloat(minInput.value);
        const max = parseFloat(maxInput.value);

        const porcentaje = slider.value / 100;
        const precio = min + (max - min) * porcentaje;

        precioActual.textContent = "$" + Math.round(precio);
    }

    slider.addEventListener("input", actualizarPrecio);
    minInput.addEventListener("input", actualizarPrecio);
    maxInput.addEventListener("input", actualizarPrecio);

    // Inicializa al cargar
    actualizarPrecio();
}