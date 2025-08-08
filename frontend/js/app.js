document.addEventListener('DOMContentLoaded', () => {
    // Função para carregar itens
    async function loadItems() {
        try {
            const response = await fetch('http://localhost:8080/backend/api.php');
            const items = await response.json();
            renderItems(items);
        } catch (error) {
            console.error('Erro ao carregar itens:', error);
        }
    }

    // Função para renderizar itens na tabela
    function renderItems(items) {
        const container = document.getElementById('items-container');
        container.innerHTML = items.map(item => `
            <div class="item-card">
                <div class="item-header">
                    <span class="item-name">${item.nome}</span>
                    <span class="item-id">ID: ${item.id}</span>
                </div>
                <div class="item-info">
                    <div class="item-detail">
                        <label>Tipo</label>
                        <span>${item.tipo}</span>
                    </div>
                    <div class="item-detail">
                        <label>Quantidade</label>
                        <span>${item.quantidade}</span>
                    </div>
                </div>
                <div class="item-actions">
                    <button onclick="editItem(${item.id})">Editar</button>
                    <button onclick="deleteItem(${item.id})">Excluir</button>
                </div>
            </div>
        `).join('');
    }

    // Carrega os itens quando a página é carregada
    loadItems();
});
