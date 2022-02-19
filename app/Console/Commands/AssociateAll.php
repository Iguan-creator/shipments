<?php

namespace App\Console\Commands;

use App\Models\Airport;
use App\Models\Car;
use App\Models\Client;
use App\Models\Container;
use App\Models\Contractor;
use App\Models\DeliveryPlace;
use App\Models\LoadPlace;
use App\Models\Port;
use App\Models\Receiver;
use App\Models\Seller;
use App\Models\Sender;
use App\Models\Station;
use Illuminate\Console\Command;

class AssociateAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'associate:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Associate all lists';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $clientIds = Client::all('id')->pluck('id');

        $this->info('Updating process has been started');
        $count = [
            Airport::count('id'),
            Car::count('id'),
            Container::count('id'),
            Contractor::count('id'),
            DeliveryPlace::count('id'),
            LoadPlace::count('id'),
            Port::count('id'),
            Receiver::count('id'),
            Seller::count('id'),
            Sender::count('id'),
            Station::count('id'),
        ];
        $count = array_sum($count);

        $bar = $this->output->createProgressBar($count);

        foreach (Airport::all('id') as $airport) {
            $airport->types()->syncWithoutDetaching([3,4,5,6,7,10]);
            $bar->advance();
        }

        foreach (Car::all('id') as $car) {
            $car->types()->syncWithoutDetaching([3,4,7,10,11]);
            $bar->advance();
        }

        foreach (Container::all('id') as $container) {
            $container->types()->syncWithoutDetaching([2,3,4,6,7,8,9,10]);
            $bar->advance();
        }

        foreach (Contractor::all('id') as $contractor) {
            $contractor->types()->syncWithoutDetaching(range(1,11));
            $bar->advance();
        }

        foreach (DeliveryPlace::all('id') as $deliveryPlace) {
            $deliveryPlace->clients()->syncWithoutDetaching($clientIds);
            $bar->advance();
        }

        foreach (LoadPlace::all('id') as $loadPlace) {
            $loadPlace->clients()->syncWithoutDetaching($clientIds);
            $bar->advance();
        }

        foreach (Port::all('id') as $port) {
            $port->types()->syncWithoutDetaching([1,2,3,4,6,7,10]);
            $bar->advance();
        }

        foreach (Receiver::all('id') as $receiver) {
            $receiver->clients()->syncWithoutDetaching($clientIds);
            $bar->advance();
        }

        foreach (Seller::all('id') as $seller) {
            $seller->clients()->syncWithoutDetaching($clientIds);
            $seller->types()->syncWithoutDetaching(range(1,11));
            $bar->advance();
        }

        foreach (Sender::all('id') as $sender) {
            $sender->clients()->syncWithoutDetaching($clientIds);
            $bar->advance();
        }

        foreach (Station::all('id') as $station) {
            $station->types()->syncWithoutDetaching([2,3,4,6,7,8,9,10]);
            $bar->advance();
        }

        $bar->finish();
        $this->info('Updating process is finished');
        return true;
    }
}
