<?php

namespace Themey99\CorrelativeNumber\Commands;

use Illuminate\Console\Command;
use Themey99\CorrelativeNumber\Contracts\CorrelativeNumber;

class CreateSequence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'correlative:create
        {modelClass : model class to create correlative sequence}
        {suffixOrPrefix : suffix or prefix to create correlative sequence}
        {--type=1 : Type correlative sequence [1 => prefix && 2 => suffix]}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new sequence';

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
     * @return int
     */
    public function handle()
    {
        $correlativeClass = app(CorrelativeNumber::class);

        $correlativeClass::findOrCreate(
            $this->argument('modelClass')
        );
    }
}
