<?php

namespace LarawireGarage\LarawireModals;

use Livewire\Component;
use LarawireGarage\LarawireModals\Traits\AsModal;

class ModalComponent extends Component
{
    use AsModal;

    protected $modal = [];

    public function render()
    {
        return view('larawire::modal', ['modal' => $this->modal]);
    }
}