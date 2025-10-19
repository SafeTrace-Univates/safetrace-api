<?php

namespace App\Models;

use App\Enums\ConnectionEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class System extends Model
{
    use SoftDeletes;

    protected $table = 'system';

    protected $connection = ConnectionEnum::SAFETRACE;

    protected $fillable = [
        'id',
        'name',
        'token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
