class ModalFactory {
  constructor() {
    this.overlay = this.createOverlay();
    document.body.appendChild(this.overlay);
  }

  createOverlay() {
    const overlay = document.createElement('div');
    overlay.id = 'modal-overlay';
    overlay.style.display = 'none';
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.backgroundColor = 'rgba(0,0,0,0.5)';
    overlay.style.zIndex = '999';
    return overlay;
  }

  createModal(options = {}) {
    const {
      id = 'custom-modal',
      title = '',
      content = '',
      width = 'auto',
      height = '600px',
      top = '150px',
      left = '250px'
    } = options;

    // Remove modal existente com o mesmo ID, se houver
    const existingModal = document.getElementById(id);
    if (existingModal) {
      existingModal.remove();
    }

    const modal = document.createElement('div');
    modal.id = id;
    modal.className = 'custom-modal';
    modal.style.display = 'none';
    modal.style.position = 'fixed';
    modal.style.top = top;
    modal.style.left = left;
    modal.style.backgroundColor = 'white';
    modal.style.padding = '20px';
    modal.style.borderRadius = '8px';
    modal.style.boxShadow = '0 0 10px rgba(0,0,0,0.3)';
    modal.style.zIndex = '1000';
    modal.style.height = height;
    modal.style.width = width;
    modal.style.overflow = 'auto';

    // Cabeçalho do modal
    const header = document.createElement('div');
    header.style.display = 'flex';
    header.style.justifyContent = 'space-between';
    header.style.alignItems = 'center';
    header.style.marginBottom = '20px';
    header.style.borderBottom = '1px solid #eee';
    header.style.paddingBottom = '10px';

    const titleElement = document.createElement('h2');
    titleElement.textContent = title;
    titleElement.style.margin = '0';

    const closeButton = document.createElement('button');
    closeButton.innerHTML = '&times;';
    closeButton.style.background = 'none';
    closeButton.style.border = 'none';
    closeButton.style.fontSize = '24px';
    closeButton.style.cursor = 'pointer';

    header.appendChild(titleElement);
    header.appendChild(closeButton);
    modal.appendChild(header);

    // Corpo do modal
    const body = document.createElement('div');
    body.className = 'modal-body';
    body.innerHTML = content;
    modal.appendChild(body);

    document.body.appendChild(modal);

    // Configura comportamentos
    closeButton.addEventListener('click', () => this.closeModal(modal));
    this.overlay.addEventListener('click', () => this.closeModal(modal));

    return {
      element: modal,
      show: () => this.showModal(modal),
      close: () => this.closeModal(modal),
      updateContent: (newContent) => {
        body.innerHTML = newContent;
      }
    };
  }

  showModal(modal) {
    modal.style.display = 'block';
    this.overlay.style.display = 'block';
  }

  closeModal(modal) {
    modal.style.display = 'none';
    this.overlay.style.display = 'none';
  }
}

// Instância global da fábrica de modais
const modalFactory = new ModalFactory();