<?php

namespace LarawireGarage\LarawireModals\Traits;

/**
 * Bootstrap modal convert to wizard mode
 */
trait Wizard
{
    public function mountWizard()
    {
        $wizard = [
            'step' => 1,
            'total' => 1,
            'submit' => '',
        ];

        $this->wizard = array_merge($wizard, $this->wizard ?? []);
    }

    public function renderedWizard($view)
    {
        return $view->with(['wizard' => $this->wizard]);
    }

    public function getWizardCurrentStep()
    {
        return intval($this->wizard['step']);
    }
    public function getWizardTotalSteps()
    {
        return $this->wizard['total'];
    }
    public function getWizardSubmitCallback()
    {
        return $this->wizard['submit'];
    }

    public function goNext()
    {
        $this->validateBeforeNext();
        $this->wizard['step'] = ++$this->wizard['step'];
    }
    public function validateBeforeNext()
    {
        if (
            isset($this->wizard['validate']) &&
            isset($this->wizard['validate'][$this->getWizardCurrentStep()]) &&
            !empty($this->wizard['validate'][$this->getWizardCurrentStep()])
        ) {
            $this->{$this->wizard['validate'][$this->getWizardCurrentStep()]}();
        }
    }
    public function goBack()
    {
        if (method_exists($this, 'beforeWizardBack')) $this->beforeWizardBack();
        $this->wizard['step'] = --$this->wizard['step'];
    }
    public function wizardSubmit()
    {
        $this->validateBeforeNext();
        $callback = $this->wizard['submit'];
        if (!empty($callback)) $this->$callback();
    }
}
