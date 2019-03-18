<?php declare(strict_types=1);

namespace Surda\Search\DI;

use Nette\DI\CompilerExtension;
use Nette\Utils\AssertionException;
use Nette\Utils\Validators;
use Surda\Search\SearchFactory;

class SearchExtension extends CompilerExtension
{
    /** @var array */
    public $defaults = [
        'template' => NULL,
        'templates' => [],
        'autocomplete' => 'on',
        'useAjax' => FALSE,
    ];

    /** @var array */
    private $templates = [
        'default' => __DIR__ . '/../Templates/bootstrap4.default.latte',
        'default-sm' => __DIR__ . '/../Templates/bootstrap4.default.sm.latte',
    ];

    /**
     * @throws AssertionException
     */
    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        try {
            $this->validate($config);
        }
        catch (AssertionException $e) {
            throw $e;
        }

        $search = $builder->addDefinition($this->prefix('search'))
            ->setImplement(SearchFactory::class)
            ->addSetup('setAutocomplete', [$config['autocomplete']])
            ->addSetup($config['useAjax'] === TRUE ? 'enableAjax' : 'disableAjax');

        $templates = $config['templates'] === [] ? $this->templates : $config['templates'];
        foreach ($templates as $type => $templateFile) {
            $search->addSetup('setTemplateByType', [$type, $templateFile]);
        }

        if ($config['template'] !== NULL) {
            $search->addSetup('setTemplate', [$config['template']]);
        }
    }

    /**
     * @param array $config
     * @throws AssertionException
     */
    private function validate(array $config): void
    {
        Validators::assertField($config, 'useAjax', 'bool');
        Validators::assertField($config, 'template', 'string|null');
        Validators::assertField($config, 'templates', 'array');
        Validators::assertField($config, 'autocomplete', 'string');
    }
}