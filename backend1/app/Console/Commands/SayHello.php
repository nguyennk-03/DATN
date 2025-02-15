<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SayHello extends Command
{
    protected $signature = 'say:hello';
    protected $description = 'In ra dòng chữ Hello, World!';

    public function handle()
    {
        $this->info('Hello, World!');
    }
}
