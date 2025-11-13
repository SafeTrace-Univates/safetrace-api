<?php

namespace App\Models;

use App\Enums\ConnectionEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = 'contact';

    protected $connection = ConnectionEnum::SAFETRACE;

    public $timestamps = true;

    protected $fillable = [
        'ref_owner',
        'ref_user',
        'nickname',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'ref_owner');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'ref_user');
    }

    public function alerts()
    {
        return $this->belongsToMany(Alert::class, 'alert_contact', 'ref_contact', 'ref_alert');
    }

    public function toSearchableArray()
    {
        return [
            'id'       => $this->id,
            'ref_user' => $this->ref_user,
            'nickname' => $this->nickname,
        ];
    }
}
