function openChat(contactName) {
    document.getElementById('chat-name').innerText = contactName;
    document.getElementById('chat-content').innerHTML = ''; // Limpa o conteúdo anterior
}

function sendMessage() {
    const message = document.getElementById('message-text').value;
    if (message.trim()) {
        const chatContent = document.getElementById('chat-content');
        const messageElement = document.createElement('div');
        messageElement.className = 'message';
        messageElement.innerText = message;
        chatContent.appendChild(messageElement);
        document.getElementById('message-text').value = ''; // Limpa o campo de texto
    }
}

// Gerar e compartilhar link para o grupo
function shareLink(contactName) {
    const chatLink = `https://chatapp.com/invite/${contactName}`;
    alert(`Link compartilhado: ${chatLink}`);
}

// Adicionar funções a um grupo
function showRoleOptions(groupName) {
    document.getElementById('overlay-role').classList.remove('hidden');
}

// Fechar a sobreposição
function closeOverlay() {
    document.getElementById('overlay-role').classList.add('hidden');
}

// Adicionar o papel selecionado
function addRole() {
    const selectedRole = document.getElementById('role-selection').value;
    const userId = document.getElementById('user-id').value;
    if (userId.trim()) {
        alert(`Papel ${selectedRole} adicionado para ${userId}`);
        closeOverlay();
    } else {
        alert('Por favor, insira um ID válido.');
    }
}

// Abre o modal para adicionar um novo grupo
function openAddGroupModal() {
    document.getElementById('add-group-modal').classList.remove('hidden');
    document.getElementById('group-name').value = '';
    document.getElementById('group-members').value = '';
    document.getElementById('group-image').value = '';
    document.getElementById('image-preview').style.display = 'none';
}

// Fecha o modal de adicionar grupo
function closeAddGroupModal() {
    document.getElementById('add-group-modal').classList.add('hidden');
}

// Função para pré-visualizar a imagem
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('image-preview');
    const reader = new FileReader();
    
    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block'; // Mostra a imagem após o carregamento
    }

    if (file) {
        reader.readAsDataURL(file);
    }
}

// Função para adicionar o grupo
function addGroup() {
    const groupName = document.getElementById('group-name').value.trim();
    const groupMembers = document.getElementById('group-members').value;
    const groupImage = document.getElementById('image-preview').src;

    if (groupName && groupMembers > 0) {
        const contactList = document.getElementById('contact-list');

        // Criar novo elemento de grupo
        const newGroup = document.createElement('div');
        newGroup.className = 'contact';
        newGroup.innerHTML = `
            <img src="${groupImage}" alt="${groupName}" style="width: 30px; height: 30px; border-radius: 50%; vertical-align: middle; margin-right: 10px;">
            ${groupName} (${groupMembers})
            <div class="options">
                <span class="dots">...</span>
                <div class="dropdown hidden">
                    <button onclick="shareLink('${groupName}')">Compartilhar Link</button>
                    <button onclick="showRoleOptions('${groupName}')">Adicionar Funções</button>
                </div>
            </div>
        `;

        // Adicionar o novo grupo à lista de contatos
        contactList.appendChild(newGroup);

        // Fechar modal e limpar campos
        closeAddGroupModal();
        document.getElementById('group-name').value = '';
        document.getElementById('group-members').value = '';
        document.getElementById('group-image').value = '';
        document.getElementById('image-preview').style.display = 'none';
    } else {
        alert('Por favor, insira um nome válido para o grupo e a quantidade de participantes.');
    }
}
