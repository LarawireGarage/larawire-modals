<?php

namespace LarawireGarage\LarawireModals\Views\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Modal ID of the parent element
     * @var string $id
     */
    public $id;
    /**
     * Title text of the modal header
     * @var string $titleText
     */
    public $titleText;
    /**
     * Indicator for Modal body containes a form
     * @var bool $hasForm
     */
    public $hasForm = false;
    /**
     * Livewire function name called when form submitted
     * @var ?string $formSubmit
     */
    public $formSubmit = null;
    /**
     * @var string $theme Theme of the modal
     */
    public $theme;

    /**
     * Supported theme templates
     *
     * @var array
     */
    private $themeTemplates = [
        'bootstrap' => 'larawire::modal-bootstrap',
        'tailwind'  => 'larawire::modal-tailwind',
    ];

    public $backdropClasses = '';
    public $containerClasses = '';
    public $windowClasses = '';
    public $headerClasses = '';
    public $headerCloseBtnClasses = '';
    public $bodyClasses = '';
    public $footerClasses = '';
    public $footerCloseBtnClasses = '';
    /**
     * @var string slide-down, scale-up
     */
    public $animation = 'scale-up';
    public $animation_enter = '';
    public $animation_enter_start = '';
    public $animation_enter_end = '';
    public $animation_leave = '';
    public $animation_leave_start = '';
    public $animation_leave_end = '';


    /**
     * Create a new component instance.
     */
    public function __construct(array $modal = [])
    {
        $this->id = $this->prepareModalID($modal);
        $this->titleText = isset($modal['titleText']) ? $modal['titleText'] : '';
        $this->theme = $this->prepareTheme($modal);

        $this->prepareClasses($modal);

        $this->animation = isset($modal['animation']) && !empty($modal['animation'])
            ? $modal['animation'] : config('larawire-modals.animation', 'slide-down');
        $this->prepareAnimation();
    }

    private function prepareClasses($modal = []): void
    {
        $themeClasses = config('larawire-modals.theme-classes');

        $this->backdropClasses = isset($modal['backdropClasses']) ? $modal['backdropClasses'] : $themeClasses[$this->theme]['backdropClasses'];
        $this->containerClasses = isset($modal['containerClasses']) ? $modal['containerClasses'] : $themeClasses[$this->theme]['containerClasses'];
        $this->windowClasses = isset($modal['windowClasses']) ? $modal['windowClasses'] : $themeClasses[$this->theme]['windowClasses'];
        $this->headerClasses = isset($modal['headerClasses']) ? $modal['headerClasses'] : $themeClasses[$this->theme]['headerClasses'];
        $this->headerCloseBtnClasses = isset($modal['headerCloseBtnClasses']) ? $modal['headerCloseBtnClasses'] : $themeClasses[$this->theme]['headerCloseBtnClasses'];
        $this->bodyClasses = isset($modal['bodyClasses']) ? $modal['bodyClasses'] : $themeClasses[$this->theme]['bodyClasses'];
        $this->footerClasses = isset($modal['footerClasses']) ? $modal['footerClasses'] : $themeClasses[$this->theme]['footerClasses'];
        $this->footerCloseBtnClasses = isset($modal['footerCloseBtnClasses']) ? $modal['footerCloseBtnClasses'] : $themeClasses[$this->theme]['footerCloseBtnClasses'];
    }
    private function prepareAnimation(): void
    {

        $animationStyles = config('larawire-modals.animation-classes');

        $this->animation_enter = $animationStyles[$this->animation]['enter'];
        $this->animation_enter_start = $animationStyles[$this->animation]['enter-start'];
        $this->animation_enter_end = $animationStyles[$this->animation]['enter-end'];
        $this->animation_leave = $animationStyles[$this->animation]['leave'];
        $this->animation_leave_start = $animationStyles[$this->animation]['leave-start'];
        $this->animation_leave_end = $animationStyles[$this->animation]['leave-end'];
    }
    private function prepareModalID(array $modal = []): string
    {
        return strtolower(isset($modal['id']) && !empty($modal['id'])
            ? $modal['id'] : 'larawire-modal-' . str()->random(5));
    }
    private function prepareTheme(array $modal = []): string
    {
        return strtolower(isset($modal['theme']) && !empty($modal['theme'])
            ? $modal['theme'] : config('larawire-modals.theme', 'bootstrap'));
    }
    /**
     * Get the component view according to the theme.
     *
     * @return string
     */
    private function getComponentView(): string
    {
        return $this->themeTemplates[$this->theme];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view($this->getComponentView());
    }
}
