<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Parameter
 * @package App\Models
 *
 * @mixin Eloquent
 *
 * @property int $id
 * @property string $table
 * @property int $order
 * @property string $plural_name
 * @property string $singular_name
 * @property string $short
 */
class Parameter extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'pivot'];
}
