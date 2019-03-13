<?php declare(strict_types=1);

namespace Tests\Surda\Search;

use Surda\Search\SearchFactory;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class SearchExtensionTest extends TestCase
{
    public function testRegistration()
    {
        /** @var Container $container */
        $container = (new ContainerFactory())->create();

        /** @var SearchFactory $factory */
        $factory = $container->getService('search.search');
        Assert::true($factory instanceof SearchFactory);

        /** @var SearchFactory $factory */
        $factory = $container->getByType(SearchFactory::class);
        Assert::true($factory instanceof SearchFactory);
    }
}

(new SearchExtensionTest())->run();