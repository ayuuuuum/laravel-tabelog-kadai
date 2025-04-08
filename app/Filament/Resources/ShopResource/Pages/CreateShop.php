<?php

namespace App\Filament\Resources\ShopResource\Pages;

use App\Filament\Resources\ShopResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateShop extends CreateRecord
{
    protected static string $resource = ShopResource::class;

    public static function mutateFormDataBeforeCreate(array $data): array
    {
    // 保存前にログを出力して、imageキーが入っているか確認
    Log::debug('mutateFormDataBeforeCreate', $data);

    return $data;
    }
}
