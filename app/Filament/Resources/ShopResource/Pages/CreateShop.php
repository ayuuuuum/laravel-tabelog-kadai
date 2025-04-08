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
        if (array_key_exists('image', $data) && is_array($data['image']) && count($data['image']) > 0) {
            $data['image'] = $data['image'][0];
        } else {
            $data['image'] = null;
        }

        // 保存前にログを出力して、imageキーが入っているか確認
        Log::debug('mutateFormDataBeforeCreate', $data);

        return $data;
    }
}
