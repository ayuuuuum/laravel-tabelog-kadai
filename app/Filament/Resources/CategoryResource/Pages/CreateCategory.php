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
        \Log::debug('🟡 mutateFormDataBeforeCreate の中身', [
            'image' => $data['image'] ?? 'imageキーなし',
            'type' => gettype($data['image'] ?? null),
        ]);
    
        // image が配列の場合のみ最初の要素を使用
        if (isset($data['image'])) {
            if (is_array($data['image'])) {
                $data['image'] = $data['image'][0] ?? null;
            }
            // 文字列ならそのままOK
        } else {
            $data['image'] = null;
        }
    
        return $data;
    }
}
