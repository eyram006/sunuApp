// MODALS PERSONNALISÉS - Remplacement complet de Bootstrap

// BLOQUER BOOTSTRAP IMMÉDIATEMENT ET AGRESSIVEMENT
(function() {
    console.log('🚫 Blocage immédiat et agressif de Bootstrap...');
    
    // Remplacer Bootstrap Modal avant qu'il ne soit chargé
    if (typeof window !== 'undefined') {
        // Bloquer complètement Bootstrap
        window.bootstrap = window.bootstrap || {};
        
        // Remplacer la classe Modal
        window.bootstrap.Modal = function() {
            console.log('🚫 Modal Bootstrap bloqué immédiatement');
            return {
                show: function() { 
                    console.log('🚫 show() Bootstrap bloqué');
                    return false;
                },
                hide: function() { 
                    console.log('🚫 hide() Bootstrap bloqué');
                    return false;
                },
                dispose: function() { 
                    console.log('🚫 dispose() Bootstrap bloqué');
                    return false;
                },
                _initializeBackDrop: function() {
                    console.log('🚫 _initializeBackDrop() Bootstrap bloqué');
                    return false;
                }
            };
        };
        
        // Bloquer aussi les instances existantes
        window.bootstrap.Modal.getInstance = function() {
            console.log('🚫 getInstance() Bootstrap bloqué');
            return null;
        };
        
        window.bootstrap.Modal.getOrCreateInstance = function() {
            console.log('🚫 getOrCreateInstance() Bootstrap bloqué');
            return null;
        };
        
        // Bloquer les événements Bootstrap
        window.bootstrap.Modal.EVENT_KEY = 'bs.modal';
        window.bootstrap.Modal.DATA_KEY = 'bs.modal';
        
        // Remplacer aussi les autres composants Bootstrap qui pourraient interférer
        window.bootstrap.Collapse = function() {
            console.log('🚫 Collapse Bootstrap bloqué');
            return { show: function() {}, hide: function() {} };
        };
        
        window.bootstrap.Dropdown = function() {
            console.log('🚫 Dropdown Bootstrap bloqué');
            return { show: function() {}, hide: function() {} };
        };
        
        // Bloquer les événements globaux Bootstrap
        if (typeof document !== 'undefined') {
            // Intercepter les clics sur les éléments data-bs-toggle
            document.addEventListener('click', function(e) {
                if (e.target.hasAttribute('data-bs-toggle') || e.target.hasAttribute('data-bs-target')) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('🚫 Événement Bootstrap bloqué:', e.target);
                    return false;
                }
            }, true);
            
            // Bloquer l'initialisation automatique de Bootstrap
            const originalQuerySelector = document.querySelector;
            const originalQuerySelectorAll = document.querySelectorAll;
            
            // Intercepter querySelector pour bloquer les modals Bootstrap
            document.querySelector = function(selector) {
                if (selector && selector.includes('[data-bs-toggle="modal"]')) {
                    console.log('🚫 querySelector Bootstrap modal bloqué:', selector);
                    return null;
                }
                return originalQuerySelector.call(this, selector);
            };
            
            // Intercepter querySelectorAll pour bloquer les modals Bootstrap
            document.querySelectorAll = function(selector) {
                if (selector && selector.includes('[data-bs-toggle="modal"]')) {
                    console.log('🚫 querySelectorAll Bootstrap modal bloqué:', selector);
                    return [];
                }
                return originalQuerySelectorAll.call(this, selector);
            };
            
            // Bloquer les mutations du DOM qui pourraient initialiser Bootstrap
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1 && node.hasAttribute && node.hasAttribute('data-bs-toggle')) {
                                console.log('🚫 Nœud Bootstrap détecté et bloqué:', node);
                                node.removeAttribute('data-bs-toggle');
                                node.removeAttribute('data-bs-target');
                            }
                        });
                    }
                });
            });
            
            // Observer les changements du DOM
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        }
    }
})();

class CustomModal {
    constructor(modalId) {
        this.modal = document.getElementById(modalId);
        this.modalId = modalId;
        this.isOpen = false;
        this.init();
    }

    init() {
        if (!this.modal) {
            console.error(`❌ Modal ${this.modalId} non trouvé`);
            return;
        }

        console.log(`🔧 Initialisation du modal ${this.modalId}`);
        
        // Créer le backdrop
        this.createBackdrop();
        
        // Gérer la fermeture
        this.setupCloseHandlers();
        
        // Gérer les formulaires
        this.setupFormHandlers();
    }

    createBackdrop() {
        this.backdrop = document.createElement('div');
        this.backdrop.className = 'custom-modal-backdrop';
        this.backdrop.id = `backdrop-${this.modalId}`;
        document.body.appendChild(this.backdrop);
    }

    setupCloseHandlers() {
        // Bouton de fermeture
        const closeBtn = this.modal.querySelector('.btn-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => this.close());
        }

        // Fermer en cliquant sur le backdrop
        this.backdrop.addEventListener('click', () => this.close());

        // Fermer avec Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.close();
            }
        });
    }

    setupFormHandlers() {
        const form = this.modal.querySelector('form');
        if (form) {
            form.addEventListener('submit', (e) => {
                console.log(`📤 Soumission du formulaire dans ${this.modalId}`);
                // Le formulaire sera soumis normalement
            });
        }
    }

    open() {
        if (this.isOpen) return;
        
        console.log(`🔓 Ouverture du modal ${this.modalId}`);
        
        // Afficher le modal et le backdrop
        this.modal.style.display = 'block';
        this.backdrop.style.display = 'block';
        
        // Ajouter la classe show
        setTimeout(() => {
            this.modal.classList.add('show');
            this.backdrop.classList.add('show');
        }, 10);
        
        this.isOpen = true;
        
        // Focus sur le premier champ
        const firstInput = this.modal.querySelector('input, select, textarea');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 100);
        }
        
        // Empêcher le scroll du body
        document.body.style.overflow = 'hidden';
    }

    close() {
        if (!this.isOpen) return;
        
        console.log(`🔒 Fermeture du modal ${this.modalId}`);
        
        // Masquer le modal et le backdrop
        this.modal.classList.remove('show');
        this.backdrop.classList.remove('show');
        
        setTimeout(() => {
            this.modal.style.display = 'none';
            this.backdrop.style.display = 'none';
        }, 300);
        
        this.isOpen = false;
        
        // Réinitialiser le formulaire
        const form = this.modal.querySelector('form');
        if (form) {
            form.reset();
            // Supprimer les messages d'erreur
            const invalidFeedbacks = form.querySelectorAll('.is-invalid');
            invalidFeedbacks.forEach(el => el.classList.remove('is-invalid'));
        }
        
        // Restaurer le scroll du body
        document.body.style.overflow = '';
    }

    destroy() {
        if (this.backdrop && this.backdrop.parentNode) {
            this.backdrop.parentNode.removeChild(this.backdrop);
        }
    }
}

// Gestionnaire global des modals
class ModalManager {
    constructor() {
        this.modals = new Map();
        this.init();
    }

    init() {
        console.log('🚀 Initialisation du gestionnaire de modals personnalisés');
        
        // Initialiser tous les modals existants
        this.initExistingModals();
        
        // Remplacer les boutons Bootstrap par nos propres boutons
        this.replaceBootstrapButtons();
    }

    initExistingModals() {
        const modalElements = document.querySelectorAll('.modal');
        modalElements.forEach(modal => {
            const modalId = modal.id;
            console.log(`🔧 Initialisation du modal ${modalId}`);
            
            const customModal = new CustomModal(modalId);
            this.modals.set(modalId, customModal);
        });
    }

    replaceBootstrapButtons() {
        // Remplacer les boutons data-bs-target
        const buttons = document.querySelectorAll('[data-bs-target]');
        buttons.forEach(button => {
            const target = button.getAttribute('data-bs-target');
            const modalId = target.replace('#', '');
            
            button.removeAttribute('data-bs-target');
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.openModal(modalId);
            });
        });
    }

    openModal(modalId) {
        const modal = this.modals.get(modalId);
        if (modal) {
            modal.open();
        } else {
            console.error(`❌ Modal ${modalId} non trouvé dans le gestionnaire`);
        }
    }

    closeModal(modalId) {
        const modal = this.modals.get(modalId);
        if (modal) {
            modal.close();
        }
    }

    closeAll() {
        this.modals.forEach(modal => modal.close());
    }
}

// Initialisation automatique
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎯 DOM chargé, initialisation des modals personnalisés...');
    
    // Initialiser notre gestionnaire
    window.modalManager = new ModalManager();
    
    console.log('✅ Gestionnaire de modals personnalisés initialisé');
});

// Fonctions globales pour compatibilité
window.openCustomModal = function(modalId) {
    if (window.modalManager) {
        window.modalManager.openModal(modalId);
    }
};

window.closeCustomModal = function(modalId) {
    if (window.modalManager) {
        window.modalManager.closeModal(modalId);
    }
};

window.closeAllCustomModals = function() {
    if (window.modalManager) {
        window.modalManager.closeAll();
    }
};
