<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

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
