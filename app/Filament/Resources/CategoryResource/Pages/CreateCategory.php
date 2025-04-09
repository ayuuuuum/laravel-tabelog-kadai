<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

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
