<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $title
 * @property string $access_token
 * @property string $status
 * @property int $account_id
 * @property bool $confirm
 * @property string $serial_number
 * @property string $last_contact
 *  */
class ControlDevice extends Authenticatable
{
    use HasFactory, HasApiTokens;

    const ONLINE_STATUS = 'online';
    const OFFLINE_STATUS = 'offline';
    const OFFLINE_INTERVAL = 60;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'serial_number',
        'confirm',
        'access_token',
        'last_contact',
        'account_id',
    ];

    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    // Статус устройства
    public function status(): string
    {
        $lastContact = Carbon::create($this->last_contact)->timestamp;
        $nowTimestamp = Carbon::now()->timestamp;
        switch ($nowTimestamp - $lastContact < self::OFFLINE_INTERVAL) {
            case true:
                return self::ONLINE_STATUS;
            default:
                return self::OFFLINE_STATUS;
        }
    }
}
