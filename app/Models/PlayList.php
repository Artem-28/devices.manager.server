<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PlayList
 *
 * @property int $id
 * @property int $account_id
 * @property string $title
 * @property string $description
 *  */
class PlayList extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'title',
        'description'
    ];

    // Привязанный аккаунт
    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    // Список элементов в плей листе
    public function contents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Content::class)->orderBy('order');
    }
}
