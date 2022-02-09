<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property boolean $active
 *  */
class Role extends Model
{
    use HasFactory;

    const ADMIN = 'admin';
    const OPERATOR = 'operator';
    const CONTROL_DEVICE = 'control_device';
    const USER = 'user';

     protected $fillable = [
        'title',
        'description',
        'slug',
        'active'
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
