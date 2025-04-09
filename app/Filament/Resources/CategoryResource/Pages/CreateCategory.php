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
        \Log::debug('mutateFormDataBeforeCreate: image', ['image' => $data['image']]);

        // imageが配列で、かつ中身があれば[0]を取り出す
        if (array_key_exists('image', $data)) {
            if (is_array($data['image']) && count($data['image']) > 0) {
                $data['image'] = $data['image'][0];
            } elseif (is_string($data['image'])) {
                // すでに文字列（保存名）の場合はそのまま
            } else {
                $data['image'] = null; // 最終手段
            }
        } else {
            $data['image'] = null;
        }

        return $data;
    }
}
