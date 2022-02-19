<?php

namespace App\Console\Commands;

use App\Models\Airport;
use App\Models\Car;
use App\Models\Client;
use App\Models\Container;
use App\Models\Contractor;
use App\Models\DeliveryCondition;
use App\Models\DeliveryPlace;
use App\Models\LoadPlace;
use App\Models\Port;
use App\Models\Receiver;
use App\Models\Seller;
use App\Models\Station;
use Illuminate\Console\Command;
use App\Models\Parameters\ShipmentAirport;
use App\Models\Parameters\ShipmentCar;
use App\Models\Parameters\ShipmentClient;
use App\Models\Parameters\ShipmentContainer;
use App\Models\Parameters\ShipmentContractor;
use App\Models\Parameters\ShipmentDeliveryCondition;
use App\Models\Parameters\ShipmentDeliveryPlace;
use App\Models\Parameters\ShipmentLoadPlace;
use App\Models\Parameters\ShipmentPort;
use App\Models\Parameters\ShipmentReceiver;
use App\Models\Parameters\ShipmentSender;
use App\Models\Parameters\ShipmentStation;

class IncrementFrequencyToLists extends Command
{
    /**
     * Команда пробегается по спискам увеличивая всем элементам frequency на 1.
     *
     * @var string
     */
    protected $signature = 'frequency:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Команда пробегается по спискам увеличивая всем элементам frequency на 1.';

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
        $this->line('[1] - заполнение');
        $this->line('[2] - обнуление');

        $question = $this->ask('Что будем делать?');

        if ($question == 1) {
            $this->initializeFrequency();
        } elseif ($question == 2) {
            $this->resetFrequency();
        } else {
            $this->error('Внимательно читай варианты ответов!');
        }
    }

    private function initializeFrequency()
    {
        $lists = [
            ShipmentClient::class,
            ShipmentContractor::class,
            ShipmentCar::class,
            ShipmentDeliveryCondition::class,
            ShipmentContainer::class,
            ShipmentPort::class,
            ShipmentAirport::class,
            ShipmentStation::class,
            ShipmentLoadPlace::class,
            ShipmentDeliveryPlace::class,
            ShipmentSender::class,
            ShipmentReceiver::class,
        ];

        $this->info('Заполнение поля frequency в списках.');
        $bar = $this->output->createProgressBar(count($lists));

        foreach ($lists as $list) {
            foreach ($list::all() as $record) {
                if ($record->value != null) {
                    $frequency = "frequency_{$record->shipment->type_id}";
                    $record->value->$frequency++;
                    $record->value->save();
                }
            }
            $bar->advance();
        }
        $bar->finish();
    }

    private function resetFrequency()
    {
        $lists = [
            Client::class,
            Seller::class,
            Contractor::class,
            Car::class,
            DeliveryCondition::class,
            Container::class,
            Port::class,
            Airport::class,
            Station::class,
            LoadPlace::class,
            DeliveryPlace::class,
            Seller::class,
            Receiver::class
        ];

        $config = array_keys(config('ini_data.types'));

        $this->info('Сброс поля frequency в списках.');
        $bar = $this->output->createProgressBar(count($lists) + 1);

        foreach ($lists as $list) {
            foreach ($list::all() as $record) {
                foreach ($config as $idType) {
                    $frequency = "frequency_{$idType}";
                    $record->$frequency = 0;
                    $record->save();
                }
            }
            $bar->advance();
        }
        $bar->finish();
    }
}
