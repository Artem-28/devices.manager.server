<?php

namespace Database\Seeders;

use App\Models\ContentType;
use Illuminate\Database\Seeder;

class ContentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'title' => 'Изображение',
                'slug' => ContentType::IMAGE_TYPE,
                'icon' => 'image',
                'description' => 'Создает контент формата изображений',
                'active' => true,
            ],
            [
                'title' => 'Видео',
                'slug' => ContentType::VIDEO_TYPE,
                'icon' => 'videocam',
                'description' => 'Создает контент формата видео',
                'active' => true,
            ],
        ];

        foreach ($types as $type) {
            ContentType::updateOrCreate([
                'slug' => $type['slug'],
            ], $type);
        }
    }
}
