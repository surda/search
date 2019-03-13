<?php declare(strict_types=1);

namespace Tests\Surda\Search;

use Nette\DI\Container;
use Surda\Search\SearchControl;
use Surda\Search\SearchFactory;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class SearchControlTest extends TestCase
{
    public function testControl()
    {
        /** @var Container $container */
        $container = (new ContainerFactory())->create();

        /** @var SearchFactory $factory */
        $factory = $container->getService('search.search');

        /** @var SearchControl $control */
        $control = $factory->create();

        Assert::same('', $control->getValue());

        $control->setValue('foo');
        Assert::same('foo', $control->getValue());
    }
}

(new SearchControlTest())->run();