<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Content
 *
 * @property int $id
 * @property int $account_id
 * @property int $play_list_id
 * @property string $content_type
 * @property int $order
 * @property string $value
 * @property string $title
 * @property string $description
 *  */
class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_type',
        'order',
        'value',
        'title',
        'description'
    ];

    protected $with = [
        'setting'
    ];

    // Привязанный аккаунт
    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    // Получение плей листа для контента
    public function playList(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PlayList::class);
    }

    // Настройки контента
    public function setting(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ContentSetting::class);
    }

    // Тип контента
    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ContentType::class, 'slug', 'content_type');
    }
}
