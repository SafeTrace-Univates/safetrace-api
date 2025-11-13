<?php

namespace App\Models;

use App\Enums\ConnectionEnum;
use Illuminate\Database\Eloquent\Model;

class Recording extends Model
{
    protected $table = 'recording';

    protected $connection = ConnectionEnum::SAFETRACE;

    public $timestamps = true;

    protected $fillable = [
        'ref_alert',
        'file_path',
        'duration',
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
