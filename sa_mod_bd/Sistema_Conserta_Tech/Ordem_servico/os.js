// Configuração do Flatpickr para datas
flatpickr("#data_termino", {
    dateFormat: "Y-m-d",
    minDate: "today",
    locale: "pt"
});

let equipmentCount = 0;

document.getElementById('add-equipment').addEventListener('click', function() {
    addEquipment();
});

function addEquipment() {
    const equipmentContainer = document.getElementById('equipment-container');
    const equipmentIndex = equipmentContainer.children.length;
    
    const equipmentDiv = document.createElement('div');
    equipmentDiv.className = 'equipment-item card mb-3';
    equipmentDiv.innerHTML = `
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Equipamento #${equipmentIndex + 1}</h5>
            <button type="button" class="btn btn-sm btn-danger remove-equipment">
                <i class="bi bi-trash"></i> Remover
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label>Fabricante:</label>
                    <input type="text" name="equipamentos[${equipmentIndex}][fabricante]" class="form-control" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Modelo:</label>
                    <input type="text" name="equipamentos[${equipmentIndex}][modelo]" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label>Número de Série:</label>
                    <input type="text" name="equipamentos[${equipmentIndex}][num_serie]" class="form-control">
                </div>
                <div class="col-md-6 mb-2">
                    <label>Número do Aparelho:</label>
                    <input type="text" name="equipamentos[${equipmentIndex}][num_aparelho]" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label>Defeito Reclamado:</label>
                    <textarea name="equipamentos[${equipmentIndex}][defeito_reclamado]" class="form-control" rows="2"></textarea>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Condição do Equipamento:</label>
                    <textarea name="equipamentos[${equipmentIndex}][condicao]" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="services-section mt-3">
                <h6>Serviços para este equipamento</h6>
                <button type="button" class="btn btn-sm btn-success add-service-btn">
                    <i class="bi bi-plus"></i> Adicionar Serviço
                </button>
                <div class="service-list mt-2" id="service-list-${equipmentIndex}">
                    <!-- Serviços serão adicionados aqui -->
                </div>
            </div>
        </div>
    `;
    
    equipmentContainer.appendChild(equipmentDiv);
    
    // Adicionar evento para remover equipamento
    equipmentDiv.querySelector('.remove-equipment').addEventListener('click', function() {
        if (equipmentContainer.children.length > 1) {
            equipmentContainer.removeChild(equipmentDiv);
            // Renumerar os equipamentos
            Array.from(equipmentContainer.children).forEach((item, index) => {
                item.querySelector('h5').textContent = `Equipamento #${index + 1}`;
            });
        } else {
            alert('É necessário ter pelo menos um equipamento.');
        }
    });
    
    // Adicionar evento para adicionar serviços
    equipmentDiv.querySelector('.add-service-btn').addEventListener('click', function() {
        addService(equipmentIndex);
    });
    
    // Adicionar um serviço inicial
    addService(equipmentIndex);
}

function addService(equipmentIndex) {
    const serviceList = document.getElementById(`service-list-${equipmentIndex}`);
    const serviceIndex = serviceList.children.length;
    
    const serviceItem = document.createElement('div');
    serviceItem.className = 'service-item border p-2 mb-2';
    serviceItem.innerHTML = `
        <div class="row">
            <div class="col-md-4 mb-2">
                <input type="text" name="equipamentos[${equipmentIndex}][servicos][${serviceIndex}][tipo_servico]" 
                       class="form-control form-control-sm" placeholder="Tipo de serviço" required>
            </div>
            <div class="col-md-4 mb-2">
                <input type="text" name="equipamentos[${equipmentIndex}][servicos][${serviceIndex}][descricao]" 
                       class="form-control form-control-sm" placeholder="Descrição">
            </div>
            <div class="col-md-3 mb-2">
                <input type="number" name="equipamentos[${equipmentIndex}][servicos][${serviceIndex}][valor]" 
                       class="form-control form-control-sm" placeholder="Valor R$" step="0.01" min="0" required>
            </div>
            <div class="col-md-1 mb-2">
                <button type="button" class="btn btn-sm btn-danger remove-service">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>
    `;
    
    serviceList.appendChild(serviceItem);
    
    // Adicionar evento para remover serviço
    serviceItem.querySelector('.remove-service').addEventListener('click', function() {
        serviceList.removeChild(serviceItem);
    });
}

// Adicionar primeiro equipamento ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    addEquipment();
});