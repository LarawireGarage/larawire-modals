document.addEventListener('alpine:init', () => {
    Alpine.data('modalBootstrap', (modalElement) => ({
        modal: null,
        init() {
            this.modal = new bootstrap.Modal(
                document.getElementById(modalElement)
            );
        },
        openModal: function () {
            if (this.modal) this.modal.show();
        },
        closeModal: function () {
            if (this.modal) this.modal.hide();
        },

        behavior: {
            ['x-on:modal:show']() {
                this.openModal();
            },
            ['x-on:modal:close']() {
                this.closeModal();
            },
            ['x-on:keydown.escape.window']() {
                this.closeModal();
            },
        }
    }));
    Alpine.data('modalTailwind', (modalElement) => ({
        show: false,
        init() {},
        openModal: function () {
            this.show = true;
            document.body.classList.add('overflow-y-hidden');
        },
        closeModal: function () {
            this.show = false;
            document.body.classList.remove('overflow-y-hidden');
        },

        behavior: {
            ['x-show']() {
                return this.show;
            },
            ['x-on:modal:show']() {
                this.openModal();
            },
            ['x-on:modal:close']() {
                this.closeModal();
            },
            ['x-on:keydown.escape.window']() {
                this.closeModal();
            },
        }
    }));
})
