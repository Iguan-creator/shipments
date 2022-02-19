<?php


namespace App\Models\Helpers;


use App\Models\Parameters\ShipmentAirport;
use App\Models\Parameters\ShipmentArrivalActualDate;
use App\Models\Parameters\ShipmentArrivalPlanDate;
use App\Models\Parameters\ShipmentArrivalPortDate;
use App\Models\Parameters\ShipmentArrivalStationDate;
use App\Models\Parameters\ShipmentBatchSize;
use App\Models\Parameters\ShipmentBatchWeight;
use App\Models\Parameters\ShipmentCar;
use App\Models\Parameters\ShipmentCarriageNumber;
use App\Models\Parameters\ShipmentClient;
use App\Models\Parameters\ShipmentComment;
use App\Models\Parameters\ShipmentContainer;
use App\Models\Parameters\ShipmentContainerNumber;
use App\Models\Parameters\ShipmentContractor;
use App\Models\Parameters\ShipmentDeliveryActualDate;
use App\Models\Parameters\ShipmentDeliveryCondition;
use App\Models\Parameters\ShipmentDeliveryEndDate;
use App\Models\Parameters\ShipmentDeliveryPlace;
use App\Models\Parameters\ShipmentHAWBNumber;
use App\Models\Parameters\ShipmentLoadDate;
use App\Models\Parameters\ShipmentLoadPlace;
use App\Models\Parameters\ShipmentMAWBNumber;
use App\Models\Parameters\ShipmentPort;
use App\Models\Parameters\ShipmentPositionNumber;
use App\Models\Parameters\ShipmentReceiver;
use App\Models\Parameters\ShipmentReleaseDate;
use App\Models\Parameters\ShipmentSendActualDate;
use App\Models\Parameters\ShipmentSender;
use App\Models\Parameters\ShipmentSendPlannedDate;
use App\Models\Parameters\ShipmentSendStationDate;
use App\Models\Parameters\ShipmentSpotQuantity;
use App\Models\Parameters\ShipmentStation;
use App\Models\Parameters\ShipmentTransportDocNumber;
use App\Models\Parameters\ShipmentBookingNumber;
use Illuminate\Database\Eloquent\Collection;

/**
 * Trait ShipmentParameterRelationships
 * @package App\Models\Helpers
 *
 * @property Collection $airports
 * @property ShipmentArrivalActualDate $arrivalActualDate
 * @property ShipmentArrivalPlanDate $arrivalPlanDate
 * @property ShipmentArrivalStationDate $arrivalStationDate
 * @property ShipmentBatchSize $batchSize
 * @property ShipmentCar $car
 * @property ShipmentCarriageNumber $carriageNumber
 * @property ShipmentClient $client
 * @property ShipmentComment $comment
 * @property ShipmentContainer $container
 * @property ShipmentContainerNumber $containerNumber
 * @property Collection $contractors
 * @property ShipmentDeliveryActualDate $deliveryActualDate
 * @property ShipmentDeliveryCondition $deliveryCondition
 * @property ShipmentDeliveryEndDate $deliveryEndDate
 * @property ShipmentDeliveryPlace $deliveryPlaces
 * @property ShipmentHAWBNumber $HAWBNumber
 * @property ShipmentLoadDate $loadDate
 * @property ShipmentLoadPlace $loadPlaces
 * @property ShipmentMAWBNumber $MAWBNumber
 * @property Collection $ports
 * @property ShipmentPositionNumber $positionNumber
 * @property ShipmentReleaseDate $releaseDate
 * @property ShipmentSendActualDate $sendActualDate
 * @property ShipmentSendPlannedDate $sendPlannedDate
 * @property ShipmentSendStationDate $sendStationDate
 * @property ShipmentSpotQuantity $spotQuantity
 * @property ShipmentReceiver $receivers
 * @property ShipmentSender $senders
 * @property Collection $stations
 * @property ShipmentTransportDocNumber $transportDocNumber
 * @property ShipmentBookingNumber $booking_number
 * @property ShipmentArrivalPortDate $arrival_port_date
 */
trait ShipmentParameterRelationships
{
    /*The list of all related fields. Just add another parameter if you need.*/

    public function airports()
    {
        return $this->hasMany(ShipmentAirport::class);
    }
    public function arrivalActualDate()
    {
        return $this->hasOne(ShipmentArrivalActualDate::class);
    }
    public function arrivalPlanDate()
    {
        return $this->hasOne(ShipmentArrivalPlanDate::class);
    }
    public function arrivalStationDate()
    {
        return $this->hasOne(ShipmentArrivalStationDate::class);
    }
    public function arrivalPortDate()
    {
        return $this->hasOne(ShipmentArrivalPortDate::class);
    }
    public function batchSize()
    {
        return $this->hasOne(ShipmentBatchSize::class);
    }
    public function batchWeight()
    {
        return $this->hasOne(ShipmentBatchWeight::class);
    }
    public function car()
    {
        return $this->hasOne(ShipmentCar::class);
    }
    public function carriageNumber()
    {
        return $this->hasOne(ShipmentCarriageNumber::class);
    }
    public function client()
    {
        return $this->hasOne(ShipmentClient::class);
    }
    public function comment()
    {
        return $this->hasOne(ShipmentComment::class);
    }
    public function container()
    {
        return $this->hasOne(ShipmentContainer::class);
    }
    public function containerNumber()
    {
        return $this->hasOne(ShipmentContainerNumber::class);
    }
    public function contractors()
    {
        return $this->hasMany(ShipmentContractor::class);
    }
    public function deliveryActualDate()
    {
        return $this->hasOne(ShipmentDeliveryActualDate::class);
    }
    public function deliveryCondition()
    {
        return $this->hasOne(ShipmentDeliveryCondition::class);
    }
    public function deliveryEndDate()
    {
        return $this->hasOne(ShipmentDeliveryEndDate::class);
    }
    public function deliveryPlaces()
    {
        return $this->hasMany(ShipmentDeliveryPlace::class);
    }
    public function HAWBNumber()
    {
        return $this->hasOne(ShipmentHAWBNumber::class);
    }
    public function loadDate()
    {
        return $this->hasOne(ShipmentLoadDate::class);
    }
    public function loadPlaces()
    {
        return $this->hasMany(ShipmentLoadPlace::class);
    }
    public function MAWBNumber()
    {
        return $this->hasOne(ShipmentMAWBNumber::class);
    }
    public function ports()
    {
        return $this->hasMany(ShipmentPort::class);
    }
    public function positionNumber()
    {
        return $this->hasOne(ShipmentPositionNumber::class);
    }
    public function releaseDate()
    {
        return $this->hasOne(ShipmentReleaseDate::class);
    }
    public function sendActualDate()
    {
        return $this->hasOne(ShipmentSendActualDate::class);
    }
    public function sendPlannedDate()
    {
        return $this->hasOne(ShipmentSendPlannedDate::class);
    }
    public function sendStationDate()
    {
        return $this->hasOne(ShipmentSendStationDate::class);
    }
    public function spotQuantity()
    {
        return $this->hasOne(ShipmentSpotQuantity::class);
    }
    public function stations()
    {
        return $this->hasMany(ShipmentStation::class);
    }
    public function transportDocNumber()
    {
        return $this->hasOne(ShipmentTransportDocNumber::class);
    }
    public function receivers()
    {
        return $this->hasMany(ShipmentReceiver::class);
    }
    public function senders()
    {
        return $this->hasMany(ShipmentSender::class);
    }
    public function bookingNumber(){
        return $this->hasOne(ShipmentBookingNumber::class);
    }
}
