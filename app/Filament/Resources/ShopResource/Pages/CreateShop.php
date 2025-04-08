<?php

namespace App\Filament\Resources\ShopResource\Pages;

use App\Filament\Resources\ShopResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateShop extends CreateRecord
{
    protected static string $resource = ShopResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        // アップロード後のimageが配列なら、最初の要素を取り出す
        if (is_array($data['image'])) {
            $data['image'] = $data['image'][0];
        }
        
        // 保存前にログを出力して、imageキーが入っているか確認
        Log::debug('mutateFormDataBeforeCreate', $data);

        return $data;
    }
}
