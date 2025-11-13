<?php

namespace App\Models;

use App\Enums\ConnectionEnum;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $table = 'alert';

    protected $connection = ConnectionEnum::SAFETRACE;

    public $timestamps = true;

    protected $fillable = [
        'ref_user',
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ref_user');
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'alert_contact', 'ref_alert', 'ref_contact');
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'ref_alert');
    }

    public function recordings()
    {
        return $this->hasMany(Recording::class, 'ref_alert');
    }

    public function toSearchableArray()
    {
        return [
            'id'       => $this->id,
            'ref_user' => $this->ref_user,
            'name'     => $this->name,
        ];
    }
}
