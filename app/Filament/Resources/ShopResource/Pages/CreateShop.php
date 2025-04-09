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
        \Log::debug('🟡 mutateFormDataBeforeCreate の中身', [
            'image' => $data['image'] ?? 'imageキーなし',
            'type' => gettype($data['image'] ?? null),
        ]);
    
        if (isset($data['image'])) {
            if (is_array($data['image'])) {
                // ログ出して確認
                \Log::debug('✅ imageが配列。中身：', $data['image']);
                $data['image'] = $data['image'][0] ?? null;
            } elseif (is_string($data['image'])) {
                \Log::debug('✅ imageが文字列：' . $data['image']);
            } else {
                \Log::debug('⚠️ imageが想定外の形式：' . gettype($data['image']));
                $data['image'] = null;
            }
        } else {
            \Log::debug('❌ imageが存在しない');
            $data['image'] = null;
        }
    
        return $data;
    }
}
