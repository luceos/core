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
use Illuminate\Translation\FileLoader;
use Symfony\Component\Yaml\Parser;

class PrefixedYamlFileLoader extends FileLoader implements Loader
{
    /**
     * Load a locale from the given JSON file path.
     *
     * @param  string  $locale
     * @return array
     */
    protected function loadJsonPaths($locale)
    {
        return collect(array_merge($this->jsonPaths, [$this->path]))
            ->reduce(function ($output, $path) use ($locale) {
                return $this->files->exists($full = "{$path}/{$locale}.yaml")
                    ? array_merge($output,
                        $this->yamlParser()->parse($this->files->get($full))
                    ) : $output;
            }, []);
    }

    protected function yamlParser()
    {
        return new Parser();
    }
}
