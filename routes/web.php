<?php

use App\Http\Controllers\AirportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\DeliveryConditionController;
use App\Http\Controllers\DeliveryPlaceController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\LoadPlaceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\ReceiverController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SenderController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Authentication routes */
Auth::routes(['register' => false, 'verify' => false]);
Route::get('/logout', [LoginController::class, 'logout']);

Route::prefix('app')->group(function () {

    /* Parameter routes */
    Route::get('parameters/{name}', [ParameterController::class, 'getParameterByName']);

    /* Type routes */
    Route::resource('types', TypeController::class)->only(['index', 'show', 'update']);

    Route::middleware('can:viewDependencies,type')->group(function () {
        Route::get('parameter_type/{type}', [TypeController::class, 'getParameterDependencies']);
        Route::get('seller_type/{type}', [TypeController::class, 'getSellerDependencies']);
        Route::get('contractor_type/{type}', [TypeController::class, 'getContractorDependencies']);
        Route::get('car_type/{type}', [TypeController::class, 'getCarDependencies']);
        Route::get('container_type/{type}', [TypeController::class, 'getContainerDependencies']);
        Route::get('airport_type/{type}', [TypeController::class, 'getAirportDependencies']);
        Route::get('port_type/{type}', [TypeController::class, 'getPortDependencies']);
        Route::get('station_type/{type}', [TypeController::class, 'getStationDependencies']);
    });

    Route::middleware('can:updateDependencies,type')->group(function () {
        Route::patch('parameter_type/{type}', [TypeController::class, 'setParameterDependencies']);
        Route::patch('seller_type/{type}', [TypeController::class, 'setSellerDependencies']);
        Route::patch('contractor_type/{type}', [TypeController::class, 'setContractorDependencies']);
        Route::patch('car_type/{type}', [TypeController::class, 'setCarDependencies']);
        Route::patch('container_type/{type}', [TypeController::class, 'setContainerDependencies']);
        Route::patch('airport_type/{type}', [TypeController::class, 'setAirportDependencies']);
        Route::patch('port_type/{type}', [TypeController::class, 'setPortDependencies']);
        Route::patch('station_type/{type}', [TypeController::class, 'setStationDependencies']);
    });

    /* Client routes */
    Route::resource('clients', ClientController::class)->except(['create', 'edit']);
    /* Change shipment owner */
    Route::patch('shipments/{shipment}/change_user', [ShipmentController::class, 'changeOwner']);

    Route::middleware('can:viewDependencies,client')->group(function () {
        Route::get('client_seller/{client}', [ClientController::class, 'getSellerDependencies']);
        Route::get('client_load_place/{client}', [ClientController::class, 'getLoadPlaceDependencies']);
        Route::get('client_delivery_place/{client}', [ClientController::class, 'getDeliveryPlaceDependencies']);
        Route::get('client_receiver/{client}', [ClientController::class, 'getReceiverDependencies']);
        Route::get('client_sender/{client}', [ClientController::class, 'getSenderDependencies']);
    });

    Route::middleware('can:updateDependencies,client')->group(function () {
        Route::patch('client_seller/{client}', [ClientController::class, 'setSellerDependencies']);
        Route::patch('client_load_place/{client}', [ClientController::class, 'setLoadPlaceDependencies']);
        Route::patch('client_delivery_place/{client}', [ClientController::class, 'setDeliveryPlaceDependencies']);
        Route::patch('client_receiver/{client}', [ClientController::class, 'setReceiverDependencies']);
        Route::patch('client_sender/{client}', [ClientController::class, 'setSenderDependencies']);
    });

    Route::post('shipment_exists', [ShipmentController::class, 'shipment_exists']);

    /* All lists route */
    Route::get('lists', [GeneralController::class, 'lists']);

//    Различия ТУТ

    /* Filtered lists by type */
    Route::get('contractors/{type}/type', [ContractorController::class, 'getContractorsByType']);
    Route::get('cars/{type}/type', [CarController::class, 'getCarsByType']);
    Route::get('containers/{type}/type', [ContainerController::class, 'getContainersByType']);
    Route::get('ports/{type}/type', [PortController::class, 'getPortsByType']);
    Route::get('airports/{type}/type', [AirportController::class, 'getAirportsByType']);
    Route::get('stations/{type}/type', [StationController::class, 'getStationsByType']);

    /* Маршруты запроса списков с учетом сортировок и вариативным количеством параметров в запросе (без фильтрации просто сортировка)*/
    Route::get('sellers/{typeId}/type', [SellerController::class, 'index']);
    Route::get('contractors/{typeId}/type', [ContractorController::class, 'index']);
    Route::get('delivery_conditions/{typeId}/type', [DeliveryConditionController::class, 'index']);
    Route::get('load_places/{typeId}/type', [LoadPlaceController::class, 'index']);
    Route::get('delivery_places/{typeId}/type', [DeliveryPlaceController::class, 'index']);
    Route::get('receivers/{typeId}/type', [ReceiverController::class, 'index']);
    Route::get('senders/{typeId}/type', [SenderController::class, 'index']);
    Route::get('clients/{typeId}/type', [ClientController::class, 'index']);

    /* Filtered lists by client */
    Route::get('load_places/{client}/client', [LoadPlaceController::class, 'getLoadPlacesByClient']);
    Route::get('delivery_places/{client}/client', [DeliveryPlaceController::class, 'getDeliveryPlacesByClient']);
    Route::get('receivers/{client}/client', [ReceiverController::class, 'getReceiversByClient']);
    Route::get('senders/{client}/client', [SenderController::class, 'getSendersByClient']);


    /* Admin Resource Controllers */
    Route::resource('sellers', SellerController::class)->except(['create', 'show', 'edit']);
    Route::resource('contractors', ContractorController::class)->except(['create', 'show', 'edit']);
    Route::resource('cars', CarController::class)->except(['create', 'show', 'edit']);
    Route::resource('containers', ContainerController::class)->except(['create', 'show', 'edit']);
    Route::resource('delivery_conditions', DeliveryConditionController::class)->except(['create', 'show', 'edit']);
    Route::resource('ports', PortController::class)->except(['create', 'show', 'edit']);
    Route::resource('airports', AirportController::class)->except(['create', 'show', 'edit']);
    Route::resource('stations', StationController::class)->except(['create', 'show', 'edit']);
    Route::resource('load_places', LoadPlaceController::class)->except(['create', 'show', 'edit']);
    Route::resource('delivery_places', DeliveryPlaceController::class)->except(['create', 'show', 'edit']);
    Route::resource('receivers', ReceiverController::class)->except(['create', 'show', 'edit']);
    Route::resource('senders', SenderController::class)->except(['create', 'show', 'edit']);
    Route::resource('users', UserController::class)->except(['create', 'edit']);

    /* Reports routes */
    Route::match(['get', 'post'], 'reports/overall', [ReportsController::class, 'overall']);
    Route::get('reports/clients', [ReportsController::class, 'indexClients']);
    Route::get('reports/employees', [ReportsController::class, 'indexEmployees']);
    Route::get('reports/sellers', [ReportsController::class, 'indexSellers']);
    Route::match(['get', 'post'], 'reports/clients/{client}', [ReportsController::class, 'byClient']);
    Route::match(['get', 'post'], 'reports/employees/{user}', [ReportsController::class, 'byEmployee']);
    Route::match(['get', 'post'], 'reports/sellers/{seller}', [ReportsController::class, 'bySeller']);
    Route::post('reports/custom', [ReportsController::class, 'custom']);

    /* Notifications routes */
    Route::get('info', [NotificationController::class, 'getNotifications']);
    Route::post('info/clear', [NotificationController::class, 'clearNotifications']);

    Route::get('parameters', [ParameterController::class, 'index']);

    /* Main routes */
    Route::resource('shipments', ShipmentController::class)->except(['index', 'create', 'edit']);
    Route::put('shipments/{shipment}/documents_sent', [ShipmentController::class, 'documentsSent']);
    Route::match(['get', 'post'], 'shipments/{type}/type', [ShipmentController::class, 'getAllByType']);
    Route::match(['get', 'post'], 'shipments/{type}/type/my', [ShipmentController::class, 'getMyByType']);
    //->middleware('auth');
    Route::match(['get', 'post'], 'shipments/{type}/type/{user}', [ShipmentController::class, 'getUserByType']);
    Route::get('parameters/{type}/type', [ShipmentController::class, 'getTypeParameters']);
    Route::get('/user', [UserController::class, 'currentUser']);
});

Route::get('shipment_finish', [ShipmentController::class, 'shipmentFinish']);
Route::get('new_client', [ClientController::class, 'newClientFromOneS']);
Route::get('new_contractor', [ContractorController::class, 'newContractorFromOneS']);
Route::get('delivered_shipments', [ShipmentController::class, 'deliveredShipments']);
Route::view('/{any}', 'vue')->where('any', '.*')->middleware('auth');

