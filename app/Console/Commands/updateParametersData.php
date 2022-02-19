<?php

namespace App\Console\Commands;

use App\Models\Parameter;
use Illuminate\Console\Command;

class updateParametersData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:parameters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates parameters table with data from ini_data';

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
     * @return void
     */
    public function handle()
    {
        $this->info('Updating process started');

        $parameters = config('ini_data.parameters');

        foreach(config('ini_data.parameters') as $parameter) {
            Parameter::where('table', $parameter['table'])
                ->update($parameter);
        }

        $this->info('Updating process finished');
    }
}
