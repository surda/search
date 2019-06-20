<?php declare(strict_types=1);

namespace Surda\Search;

trait TSearch
{
    /** @var string @persistent */
    public $search = '';

    /** @var SearchFactory */
    private $searchFactory;

    /**
     * @param SearchFactory $searchFactory
     */
    public function injectSearchFactory(SearchFactory $searchFactory): void
    {
        $this->searchFactory = $searchFactory;
    }

    /**
     * @return SearchControl
     */
    protected function createComponentSearche(): SearchControl
    {
        // Init search component
        $control = $this->searchFactory->create();
        $control->setValue($this->search);

        // Define event
        $control->onChange[] = function (SearchControl $control, string $value): void {
            $this->redirect('this', ['search' => $value]);
        };

        return $control;
    }
}