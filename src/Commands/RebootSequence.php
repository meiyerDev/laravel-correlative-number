<?php

namespace Themey99\CorrelativeNumber\Commands;

use Illuminate\Console\Command;
use Themey99\CorrelativeNumber\Contracts\CorrelativeNumber;

class RebootSequence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'correlative:reboot-sequence
        {--modelClass|-mc : model class to create correlative sequence}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset sequence to correlatives';

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

        $correlativeClass::rebootSequence(
            $this->option('modelClass')
        );
    }
}
