<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TestTrans extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'trans {expression} {lang?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows the Translation line.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expression = $this->argument('expression') ;
        $lang = $this->argument('lang') ;

        if (!$expression) {
            $expression = $this->ask('?') ;
            if (!$expression) {
                $this->error("ok, bye :(") ;
                return ;
            }
        }

        $expression = str_replace('"', null, $expression) ;
        $expression = str_replace("'", null, $expression) ;
        $expression = trim($expression) ;

        if (Lang::has($expression, $lang)) {
            $this->info(trans($expression, [], $lang)) ;
        } elseif (Lang::has($expression)) {
            $this->warn("Sorry, but we have this, in " . App::getLocale() . ": ") ;
            $this->line(trans($expression, [])) ;
        } else {
            $this->error("Sorry, but nothing found!") ;
        }

        return ;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['expression', InputArgument::OPTIONAL, 'The translation expression'],
            ['lang', InputArgument::OPTIONAL, 'The request language. Fa if not provided.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
        ];
    }
}
