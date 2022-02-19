<?php

namespace App\HelperClasses;

/**
 * Trait ChangeFrequency Этот трейт стоит добавлять в модели если нам интересно следить за частотой использования записей из этой таблицы
 * инкриментируется frequency при создании и обновлении записи
 *
 * @package App\HelperClasses
 */
trait ChangeFrequency
{

    protected static function booted()
    {
        static::created(function ($parameter) {

            self::changeFrequency($parameter);
        });

        static::updated(function ($parameter) {

            self::changeFrequency($parameter);
        });
    }

    /**
     * Инкриментирует frequency в списках при создании и изменении таблиц с их участием
     *
     * @param $parameter
     */
    protected static function changeFrequency($parameter)
    {
        $parameter->refresh();
        if ($parameter->value) {
            $frequency = "frequency_{$parameter->shipment->type->id}";
            $parameter->value->$frequency++;
            $parameter->value->save();
        }
    }

}
