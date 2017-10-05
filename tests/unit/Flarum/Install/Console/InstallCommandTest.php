<?php

/*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Install\Console;

use Flarum\Tests\Concerns\InteractsWithConsole;
use Flarum\Tests\TestCase;

class InstallCommandTest extends TestCase
{
    use InteractsWithConsole;

    public function test_installation_using_command()
    {
        $this->runCommand('install --defaults');
    }
}