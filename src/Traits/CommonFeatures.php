<?php

namespace LarawireGarage\LarawireModals\Traits;

use Livewire\Attributes\On;

/**
 * add common features to livewire component
 *
 * @property array $listeners
 */
trait CommonFeatures
{
    #[On('refreshEvent')]
    public function refreshComp()
    {
        $this->dispatch('$refresh')->self();
    }
}
