<?php

namespace App\Filament\Resources\ShopResource\Pages;

use App\Filament\Resources\ShopResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditShop extends EditRecord
{
    protected static string $resource = ShopResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
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
