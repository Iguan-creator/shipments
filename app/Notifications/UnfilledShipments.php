<?php

namespace App\Notifications;

use App\HelperClasses\FormatHtml;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnfilledShipments extends Notification
{
    use Queueable;

    /**
     * Notification data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $message = new MailMessage;
        $message->subject('Незаполненные перевозки');
        $message->line('Выявлены следующие недочеты');
        if (count($this->data)) {
            $this->buildMailShipmentsList($this->data, $message);
        }
        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->data;
    }

    /**
     * Build shipments list
     *
     * @param array $array
     * @param MailMessage $message
     */
    protected function buildMailShipmentsList(Array $array, MailMessage $message)
    {
        foreach ($array as $shipment) {
            if ($shipment['type'] === 'unfilled') {
                $info = 'Не заполнено ';
            } elseif ($shipment['type'] === 'arrivalOutdated') {
                $info = 'Превышен срок отправки ';
            } elseif ($shipment['type'] === 'sendOutdated') {
                $info = 'Превышен срок доставки ';
            } else {
                $info = '';
            }
            $str = $info . ' ' . $shipment['position_number'] . (isset($shipment['unfilled_fields'])? ' (' . implode('; ', $shipment['unfilled_fields']) . ')' : '');
            $text = new FormatHtml($str);
            $text->toA(config('app.url') . '/' . $shipment['id'] . '/edit');
            $message->line($text);
        }
    }
}
