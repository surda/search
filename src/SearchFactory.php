<?php declare(strict_types=1);

namespace Surda\Search;

interface SearchFactory
{
    /**
     * @return SearchControl
     */
    public function create(): SearchControl;
}
