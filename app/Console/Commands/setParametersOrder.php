<?php

namespace App\Console\Commands;

use App\Models\Parameter;
use Illuminate\Console\Command;

class setParametersOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parameters:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set parameters order according to the config file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $parameters = Parameter::all();
        $orders = config('ini_order_parameters.parameters');
        $this->info('Setting order started');

        foreach ($parameters as $parameter) {
            /** @var Parameter $parameter */
            $parameter->order = $orders[$parameter->id]['order'] ?? 0;
            $parameter->save();
        }

        $this->info('Setting order finished');
    }
}
