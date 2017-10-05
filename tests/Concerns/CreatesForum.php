<?php

namespace Flarum\Tests\Concerns;

use Flarum\Foundation\Application;
use Flarum\Foundation\Site;

trait CreatesForum
{
    /**
     * @var Site
     */
    protected $site;

    /**
     * @var Application
     */
    protected $app;

    public function setUpForum()
    {
        $this->site = new Site();
        $this->app = $this->site->boot();
    }
}