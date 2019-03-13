<?php declare(strict_types=1);

namespace Surda\Search;

use Nette\Application\UI;
use Nette\Forms\Controls\SubmitButton;
use Nette\Utils\ArrayHash;
use Surda\ComponentHelpers\Traits\Themeable;

class SearchControl extends UI\Control
{
    use Themeable;

    /** @var string */
    protected $value = '';

    /** @var bool */
    protected $useAjax = FALSE;

    /** @var string */
    protected $autocomplete = 'on';

    /** @var array */
    public $onChange;

    /**
     * @param string $templateType
     */
    public function render(string $templateType = 'default'): void
    {
        /** @var \Nette\Application\UI\ITemplate $template */
        $template = $this->template;
        $template->setFile($this->getTemplateByType($templateType));

        $template->value = $this->getValue();

        $template->render();
    }

    /**
     * @param string $value
     */
    public function handleChange(string $value): void
    {
        $this->setValue($value);
        $this->redrawControl('SearchSnippet');
        $this->onChange($this, $value);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function enableAjax(): void
    {
        $this->useAjax = TRUE;
    }

    public function disableAjax(): void
    {
        $this->useAjax = FALSE;
    }

    /**
     * @param string $autocomplete
     */
    public function setAutocomplete(string $autocomplete): void
    {
        $this->autocomplete = $autocomplete;
    }

    /**
     * @param UI\Form   $form
     * @param ArrayHash $values
     */
    public function formSucceeded(UI\Form $form, ArrayHash $values): void
    {
        /** @var SubmitButton $button */
        $button = $form->getComponent('reset');
        $this->handleChange($button->isSubmittedBy() ? '' : $values->search);
    }

    /**
     * @return UI\Form
     */
    protected function createComponentForm(): UI\Form
    {
        $form = new UI\Form();
        $form->onSuccess[] = [$this, 'formSucceeded'];

        $form->addText('search', NULL)
            ->setAttribute('type', 'search')
            ->setAttribute('class', 'form-control')
            ->setAttribute('placeholder', 'Hledej')
            ->setAttribute('autocomplete', $this->autocomplete)
            ->setDefaultValue($this->value)
            ->setRequired('Uveďte hledaný text.');

        $form->addSubmit('send', 'Hledej');

        $form->addSubmit('reset', 'Vymaž')
            ->setValidationScope([]);

        return $form;
    }
}