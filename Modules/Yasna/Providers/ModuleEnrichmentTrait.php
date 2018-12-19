<?php
namespace Modules\Yasna\Providers;

use Illuminate\Foundation\AliasLoader;
use Nwidart\Modules\Facades\Module;

trait ModuleEnrichmentTrait
{
    protected function registerEnrichment()
    {
        $this->registerProviders() ;
        $this->registerAliases() ;
    }

    /**
     * Register some Aliases
     * @return $this
     */
    protected function registerAliases()
    {
        foreach ($this->aliases as $alias => $original) {
            AliasLoader::getInstance()->alias($alias, $original);
        }

        return $this;
    }

    /**
     * Register other Service Providers
     * @return $this
     */
    private function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }

        return $this;
    }
}
