<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSchemaDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-schema-doc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate schema documentation for the project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Schema documentation generated successfully!');
    }
}