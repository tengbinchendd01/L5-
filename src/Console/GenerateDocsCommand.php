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
    protected $name = 'l5-swagger:generate';

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
        $project  = $this->ask("which project do you want to generateDocs ?? ") ;
        $this->info('Regenerating docs' ,$project) ;
        Generator::generateDocs($project);

    }
}
