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
        // ログで確認（確認したら消してOK）
        \Log::debug('CreateShop image value', ['image' => $data['image']]);

        return $data;
    }
}
