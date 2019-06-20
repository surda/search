<?php declare(strict_types=1);

namespace Surda\Search\DI;

use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Nette\Utils\AssertionException;
use Surda\Search\SearchFactory;

class SearchExtension extends CompilerExtension
{
    /** @var array */
    private $templates = [
        'default' => __DIR__ . '/../Templates/bootstrap4.default.latte',
        'default-sm' => __DIR__ . '/../Templates/bootstrap4.default.sm.latte',
    ];

    public function getConfigSchema(): Schema
    {
        return Expect::structure([
            'autocomplete' => Expect::string('on'),
            'useAjax' => Expect::bool(FALSE),
            'template' => Expect::string()->nullable()->default(NULL),
            'templates' => Expect::array()->default([]),
        ]);
    }

    /**
     * @throws AssertionException
     */
    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();
        $config = $this->config;

        $searchFactory = $builder->addFactoryDefinition($this->prefix('controlFactory'))
            ->setImplement(SearchFactory::class);

        $searchDefinition = $searchFactory->getResultDefinition();

        $searchDefinition->addSetup('setAutocomplete', [$config->autocomplete]);
        $searchDefinition->addSetup($config->useAjax === TRUE ? 'enableAjax' : 'disableAjax');

        $templates = $config->templates === [] ? $this->templates : $config->templates;

        foreach ($templates as $type => $templateFile) {
            $searchDefinition->addSetup('setTemplateByType', [$type, $templateFile]);
        }

        if ($config->template !== NULL) {
            $searchDefinition->addSetup('setTemplate', [$config->template]);
        }
    }
}