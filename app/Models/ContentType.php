<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContentType
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $icon
 * @property string $description
 * @property boolean $active
 *  */
class ContentType extends Model
{
    use HasFactory;

    const IMAGE_TYPE = 'imageType';
    const VIDEO_TYPE = 'videoType';

    protected $fillable = [
        'title',
        'description',
        'slug',
        'icon',
        'active'
    ];
}
