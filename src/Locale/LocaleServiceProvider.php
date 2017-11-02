<?php

/*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarum\Locale;

use Flarum\Event\ConfigureLocales;
use Flarum\Foundation\AbstractServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Translation\Translator;

class LocaleServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Dispatcher $events)
    {
        $locales = $this->app->make('flarum.localeManager');

        $locales->addLocale($this->getDefaultLocale(), 'Default');

        $events->fire(new ConfigureLocales($locales));
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton(LocaleManager::class);
        $this->app->alias(LocaleManager::class, 'flarum.localeManager');

        $this->app->singleton('translator', function () {
            $defaultLocale = $this->getDefaultLocale();

            // @todo default locale is set as locale and as fallback!
            $translator = new Translator(new PrefixedYamlFileLoader(), $defaultLocale);
            $translator->setFallback($defaultLocale);

            return $translator;
        });
        $this->app->alias('translator', Translator::class);
    }

    private function getDefaultLocale()
    {
        return $this->app->isInstalled() && $this->app->isUpToDate()
            ? $this->app->make('flarum.settings')->get('default_locale', 'en')
            : 'en';
    }
}
