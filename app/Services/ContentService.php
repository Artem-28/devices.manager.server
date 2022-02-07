<?php

namespace App\Services;

use App\Models\Content;
use App\Models\ContentSetting;
use Illuminate\Support\Facades\DB;

class ContentService
{
    // Добавление контента в плейлист
    public function createContent($data, $playList)
    {
        return DB::transaction(function () use ($data, $playList) {
            // Создание класса контента
            $content = new Content($data['content']);
            $content->account_id = $playList->account_id;

            // Добавление контента к плейлисту
            $playList->contents()->save($content);

            // Создание класса настроек
            $setting = new ContentSetting($data['setting']);

            // Добавление настроек к контенту
            $content->setting()->save($setting);
            return $content;
        });
    }

    // Получение элементов плейлиста
    public function getPlayListContents($playListId)
    {
        $accountId = auth()->user()->account_id;
        return Content::where([
            ['account_id', $accountId],
            ['play_list_id', $playListId]
        ])->get();
    }

    // Удаление контента
    public function deleteContent($playListId, $contentId)
    {
        $accountId = auth()->user()->account_id;

        Content::where([
            ['account_id', $accountId],
            ['play_list_id', $playListId]
        ])
            ->find($contentId)
            ->delete();
    }

    public function getContentById($playListId, $contentId)
    {
        $accountId = auth()->user()->account_id;

        // Получение контента
        return Content::where([
            ['account_id', $accountId],
            ['play_list_id', $playListId]
        ])->find($contentId);
    }

    // Обновление контента
    public function updateContent($data, $playListId, $contentId)
    {
        $accountId = auth()->user()->account_id;

        // Получение контента
        $content = Content::where([
            ['account_id', $accountId],
            ['play_list_id', $playListId]
        ])->find($contentId);

        // Обновление контента
        if($content && array_key_exists('content', $data)) {
            $content->update($data['content']);
        }

        // Обновление настроек контента
        if($content && array_key_exists('setting', $data)) {
            $content->setting->update($data['setting']);
        }
        return $content;
    }
}
