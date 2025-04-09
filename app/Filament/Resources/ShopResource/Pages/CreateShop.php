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
        // デバッグログ：アップロードデータの中身確認！
        \Log::debug('CreateShop image data', ['image' => $data['image'] ?? 'not set']);

        // 文字列 or 配列の両対応
        if (is_array($data['image'])) {
            $data['image'] = $data['image'][0] ?? null;
        }

        return $data;
    }
}
