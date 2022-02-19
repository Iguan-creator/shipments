<?php

namespace App\Models;

use App\Models\Helpers\AssociatedWithType;
use App\Models\Helpers\HiddenFrequencyModel;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Car
 * @package App\Models
 *
 * @mixin Eloquent
 *
 * @property int $id
 * @property string $name
 */
class Car extends Model
{
    use HasFactory, AssociatedWithType;

    protected $fillable = ['name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'frequency',
        'frequency_1',
        'frequency_2',
        'frequency_3',
        'frequency_4',
        'frequency_5',
        'frequency_6',
        'frequency_7',
        'frequency_8',
        'frequency_9',
        'frequency_10',
        'frequency_11',
        'created_at',
        'updated_at'
    ];
}
