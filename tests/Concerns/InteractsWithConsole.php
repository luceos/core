<?php

namespace Flarum\Tests\Concerns;

use Flarum\Console\Server;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

trait InteractsWithConsole
{
    public function runCommand(string $command)
    {
        $this->setRunTestInSeparateProcess(true);

        $body = fopen('php://temp', 'wb+');
        $input = new StringInput("$command");
        $output = new StreamOutput($body);

        Server::fromSite($this->site)->listen($input, $output);
    }
}