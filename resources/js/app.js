import 'bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content;
}

window.manutencaoForm = function (pecasIniciais, marcasIniciais, veiculosData) {
    return {
        veiculoId: '',
        tipoManutencaoId: '',
        pecasDisponiveis: pecasIniciais,
        marcasDisponiveis: marcasIniciais,
        linhas: [{ peca_id: '', marca_id: '', quantidade: 1 }],
        quickCreateTarget: null,
        quickCreateNome: '',
        quickCreateError: '',

        get tiposManutencaoDisponiveis() {
            const v = veiculosData[this.veiculoId];
            return v ? v.tipos_manutencao : [];
        },

        addLinha() {
            this.linhas.push({ peca_id: '', marca_id: '', quantidade: 1 });
        },

        removeLinha(index) {
            if (this.linhas.length > 1) this.linhas.splice(index, 1);
        },

        openQuickCreate(type, rowIndex) {
            this.quickCreateTarget = { type, rowIndex };
            this.quickCreateNome = '';
            this.quickCreateError = '';
            const modalEl = document.getElementById('quickCreateModal');
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        },

        async submitQuickCreate() {
            if (!this.quickCreateNome?.trim()) {
                this.quickCreateError = 'Informe um nome.';
                return;
            }

            const endpoint = this.quickCreateTarget.type === 'peca' ? '/ajax/pecas' : '/ajax/marcas';

            const res = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken(),
                },
                body: JSON.stringify({ nome: this.quickCreateNome }),
            });
            const data = await res.json();

            if (!res.ok) {
                this.quickCreateError = data.errors?.nome?.[0] || 'Erro ao salvar.';
                return;
            }

            if (this.quickCreateTarget.type === 'peca') {
                this.pecasDisponiveis.push(data);
                this.linhas[this.quickCreateTarget.rowIndex].peca_id = data.id;
            } else {
                this.marcasDisponiveis.push(data);
                this.linhas[this.quickCreateTarget.rowIndex].marca_id = data.id;
            }

            bootstrap.Modal.getInstance(document.getElementById('quickCreateModal'))?.hide();
        },
    };
};

Alpine.start();
