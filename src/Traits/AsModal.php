<?php

namespace LarawireGarage\LarawireModals\Traits;

use Livewire\Attributes\On;
use Livewire\ImplicitlyBoundMethod;

/**
 * Add bootstrap modal behavior
 *
 * @property array $modal 
 */
trait AsModal
{
    public function bootedAsModal()
    {
        if (isset($this->modal) && is_array($this->modal)) {
            $this->modal = array_merge([
                'id'                        => 'sample_modal_' . time(),
                'title'                     => 'Sample Modal',
                'theme'                     => config('larawire-modals.theme', 'bootstrap'),
                'resetBeforeShow'           => config('larawire-modals.resetBeforeShow', true),
                'resetValidationBeforeShow' => config('larawire-modals.resetValidationBeforeShow', true),
            ], $this->modal);
        }
    }
    public function fireShowModalEvent()
    {
        $this->dispatch('modal:show');
    }
    public function fireCloseModalEvent()
    {
        $this->dispatch('modal:close');
    }

    #[On('show')]
    public function showModal(...$data): void
    {
        if ($this->modal['resetBeforeShow']) {
            $this->reset();
        }
        if ($this->modal['resetValidationBeforeShow']) {
            $this->resetValidation();
        }

        if (method_exists($this, 'beforeShow')) {
            ImplicitlyBoundMethod::call(app(), [$this, 'beforeShow'], ...$data);
        }

        $this->fireShowModalEvent();
    }

    #[On('close')]
    public function closeModal()
    {
        if (method_exists($this, 'beforeClose')) {
            $this->beforeClose();
        }

        $this->fireCloseModalEvent();
    }
}
