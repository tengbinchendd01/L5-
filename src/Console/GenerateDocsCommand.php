<?php

namespace L5Swagger\Console;

use L5Swagger\Generator;
use Illuminate\Console\Command;

class GenerateDocsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "l5-swagger:generate {projectVersion}";
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate docs By multi project please send command with project catalog ';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $project = $this->argument('projectVersion');
        $this->info('Regenerating docs', $project);
        Generator::generateDocs($project);

    }
}
