<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\File
 *
 * @property int $id
 * @property int $account_id
 * @property string $original_name
 * @property string $path
 *  */
class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_name',
        'path'
    ];

    // Аккаунт к которому принадлежит файл
    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    // Список контента к которому привязан файл
    public function contents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Content::class);
    }

    // Получение размера файла
    public function size()
    {
        return stat('storage/' . $this->path)['size'];
    }
}
