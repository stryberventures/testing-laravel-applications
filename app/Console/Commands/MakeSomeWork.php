<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeSomeWork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        sleep(3);

        $this->info('Success!');

        return Command::SUCCESS;
    }
}
