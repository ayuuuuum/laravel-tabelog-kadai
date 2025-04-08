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
        if (is_array($data['image']) && count($data['image']) > 0) {
            $data['image'] = $data['image'][0];
        } else {
            $data['image'] = null; // または '' にするなどして空の処理
        }

        // 保存前にログを出力して、imageキーが入っているか確認
        Log::debug('mutateFormDataBeforeCreate', $data);

        return $data;
    }
}
