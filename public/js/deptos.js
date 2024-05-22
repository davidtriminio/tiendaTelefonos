document.addEventListener('DOMContentLoaded', () => {
    const departamentoSelect = document.getElementById('departamento');
    const municipioSelect = document.getElementById('municipio');

    departamentoSelect.addEventListener('change', () => {
        const selectedDepartamento = departamentoSelect.value;
        updateMunicipioOptions(selectedDepartamento);
    });

    function updateMunicipioOptions(departamento) {
        // Limpia las opciones actuales del select de municipios
        municipioSelect.innerHTML = '<option value="">Open this select menu</option>';

        if (municipios[departamento]) {
            for (const [key, value] of Object.entries(municipios[departamento])) {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = value;
                municipioSelect.appendChild(option);
            }
        }
    }
});
