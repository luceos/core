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

use Illuminate\Contracts\Translation\Translator;

class LocaleManager
{
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var array
     */
    protected $locales = [];

    /**
     * @var array
     */
    protected $js = [];

    /**
     * @var array
     */
    protected $css = [];

    /**
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->translator->getLocale();
    }

    /**
     * @param $locale
     */
    public function setLocale($locale)
    {
        $this->translator->setLocale($locale);
    }

    /**
     * @param $locale
     * @param $name
     */
    public function addLocale($locale, $name)
    {
        $this->locales[$locale] = $name;
    }

    /**
     * @return array
     */
    public function getLocales()
    {
        return $this->locales;
    }

    /**
     * @param $locale
     * @return bool
     */
    public function hasLocale($locale)
    {
        return isset($this->locales[$locale]);
    }

    /**
     * @param $locale
     * @param $file
     * @param null $module
     */
    public function addTranslations($locale, $file, $module = null)
    {
        $prefix = $module ? $module.'::' : '';

        $this->translator->getLoader()->load(compact('file', 'prefix'), $locale);
    }

    /**
     * @param $locale
     * @param $js
     */
    public function addJsFile($locale, $js)
    {
        $this->js[$locale][] = $js;
    }

    /**
     * @param $locale
     * @return array|mixed
     */
    public function getJsFiles($locale)
    {
        $files = array_get($this->js, $locale, []);

        $parts = explode('-', $locale);

        if (count($parts) > 1) {
            $files = array_merge(array_get($this->js, $parts[0], []), $files);
        }

        return $files;
    }

    /**
     * @param $locale
     * @param $css
     */
    public function addCssFile($locale, $css)
    {
        $this->css[$locale][] = $css;
    }

    /**
     * @param $locale
     * @return array|mixed
     */
    public function getCssFiles($locale)
    {
        $files = array_get($this->css, $locale, []);

        $parts = explode('-', $locale);

        if (count($parts) > 1) {
            $files = array_merge(array_get($this->css, $parts[0], []), $files);
        }

        return $files;
    }

    /**
     * @return Translator
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @param Translator $translator
     */
    public function setTranslator(Translator $translator)
    {
        $this->translator = $translator;
    }
}
