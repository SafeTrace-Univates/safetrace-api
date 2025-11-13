<?php

namespace App\Models;

use App\Enums\ConnectionEnum;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';

    protected $connection = ConnectionEnum::SAFETRACE;

    public $timestamps = true;

    protected $fillable = [
        'ref_alert',
        'latitude',
        'longitude',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function alert()
    {
        return $this->belongsTo(Alert::class, 'ref_alert');
    }
}
