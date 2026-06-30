import 'bootstrap';
import Alpine from 'alpinejs';
import TomSelect from 'tom-select';

window.Alpine = Alpine;
window.TomSelect = TomSelect;

Alpine.start();

// Helper: initialize a Tom-Select on a given element with optional quick-create endpoint
window.initTomSelect = function(el, options = {}) {
    if (el._tomSelect) return el._tomSelect;
    const ts = new TomSelect(el, {
        create: false,
        allowEmptyOption: true,
        ...options,
    });
    return ts;
};

// Quick-create modal logic (marca / peca)
document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    document.querySelectorAll('[data-quick-create-modal]').forEach(modalEl => {
        const form = modalEl.querySelector('form');
        const feedback = modalEl.querySelector('.invalid-feedback, .text-danger');

        form?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const endpoint = form.dataset.endpoint;
            const nameInput = form.querySelector('input[name="nome"]');
            feedback && (feedback.textContent = '');
            nameInput?.classList.remove('is-invalid');

            try {
                const res = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ nome: nameInput?.value }),
                });
                const data = await res.json();

                if (!res.ok) {
                    if (data.errors?.nome) {
                        nameInput?.classList.add('is-invalid');
                        if (feedback) feedback.textContent = data.errors.nome[0];
                    }
                    return;
                }

                // Inject into all Tom-Select instances that have a matching target attribute
                const targetAttr = form.dataset.target;
                document.querySelectorAll(`[data-ts-target="${targetAttr}"]`).forEach(selectEl => {
                    if (selectEl._tomSelect) {
                        selectEl._tomSelect.addOption({ value: data.id, text: data.nome });
                        selectEl._tomSelect.addItem(data.id);
                    }
                });

                bootstrap.Modal.getInstance(modalEl)?.hide();
                nameInput && (nameInput.value = '');

            } catch (err) {
                console.error('Quick-create error:', err);
            }
        });
    });
});
