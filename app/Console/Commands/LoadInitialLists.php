<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LoadInitialLists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ini:lists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load initial lists';

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
        $this->info('Updating is started');

        $dir = database_path('/data');
        $files = array_slice(scandir($dir), 2);

        foreach ($files as $file) {
            $table = substr($file, 0, -4);

            $names = file($dir . '/' . $file);

            foreach ($names as $name) {
                $row = trim($name);

                DB::table($table)->updateOrInsert(
                    ['name' => $name],
                    ['name' => $name]);
            }
        }

        $this->info('Updating is complete');
    }
}
