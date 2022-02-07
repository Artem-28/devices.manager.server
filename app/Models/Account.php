<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Account
 *
 * @property int $id
 * @property string $title
 *  */
class Account extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title'
    ];

    // Список пользователей
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'account_id');
    }

    // Список устройств
    public function controlDevices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ControlDevice::class);
    }

    // Список плей листов
    public function playLists(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PlayList::class);
    }

    // Список файлов для аккаунта
    public function files(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(File::class);
    }
}
