<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateProjectDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-project-doc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate project documentation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Project documentation generated successfully!');
    }
}