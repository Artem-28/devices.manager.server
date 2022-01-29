<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContentSetting
 *
 * @property int $id
 * @property int|null $duration
 * @property int|null $repeat
 *  */
class ContentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'duration',
        'repeat',
    ];

    public function content(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

}
