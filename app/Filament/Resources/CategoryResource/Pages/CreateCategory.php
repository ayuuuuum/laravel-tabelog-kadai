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
        // ログで事前確認
        Log::debug('before mutateFormDataBeforeCreate', ['image' => $data['image'] ?? 'なし']);

        if (is_array($data['image'])) {
            // 配列の場合は最初の1件だけ
            $data['image'] = $data['image'][0] ?? null;
        }

        // 文字列ならそのままでOK
        return $data;
    }
}
