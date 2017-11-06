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

use Illuminate\Contracts\Translation\Loader;
use Symfony\Component\Translation\Loader\YamlFileLoader;

class PrefixedYamlFileLoader extends YamlFileLoader implements Loader
{
    /**
     * {@inheritdoc}
     */
    public function load($resource, $locale, $domain = 'messages')
    {
        if (!isset($resource['file'])) debug_print_backtrace();
        $catalogue = parent::load($resource['file'], $locale, $domain);

        if (! empty($resource['prefix'])) {
            $messages = $catalogue->all($domain);

            $prefixedKeys = array_map(function ($k) use ($resource) {
                return $resource['prefix'].$k;
            }, array_keys($messages));

            $catalogue->replace(array_combine($prefixedKeys, $messages));
        }

        return $catalogue;
    }

    /**
     * Add a new namespace to the loader.
     *
     * @param  string $namespace
     * @param  string $hint
     * @return void
     */
    public function addNamespace($namespace, $hint)
    {
        // TODO: Implement addNamespace() method.
    }

    /**
     * Add a new JSON path to the loader.
     *
     * @param  string $path
     * @return void
     */
    public function addJsonPath($path)
    {
        // TODO: Implement addJsonPath() method.
    }

    /**
     * Get an array of all the registered namespaces.
     *
     * @return array
     */
    public function namespaces()
    {
        // TODO: Implement namespaces() method.
    }
}
