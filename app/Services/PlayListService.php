<?php

namespace App\Services;

use App\Models\PlayList;

class PlayListService
{
    // Создание нового play листа
    public function createPlayList(&$data): PlayList
    {
        $accountId = auth()->user()->account_id;
        $data['account_id'] = $accountId;

        $playList = new PlayList($data);
        $playList->save();

        return $playList;
    }

    // Получение списка play листов
    public function getPlayLists()
    {
        $accountId = auth()->user()->account_id;

        return PlayList::where('account_id', $accountId)->get();
    }

    // Обновление play листа
    public function updatePlayList($data, $playListId)
    {
        $accountId = auth()->user()->account_id;
        $playList = PlayList::where([
            ['account_id', $accountId]
        ])->find($playListId);

        $playList->fill($data)->save();

        return $playList;
    }

    // Удаление play листа
    public function deletePlayList($playListId)
    {
        $accountId = auth()->user()->account_id;
        return PlayList::where([
            ['account_id', $accountId]
        ])->find($playListId)->delete();
    }

    // Получение play листа по id
    public function getPlayListById($playListId)
    {
        $accountId = auth()->user()->account_id;

        return PlayList::where('account_id', $accountId)->find($playListId);
    }
}
