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
        \Log::debug('画像の状態:', ['image' => $data['image']]);

        if (is_array($data['image']) && count($data['image']) > 0) {
            $data['image'] = $data['image'][0];
        } elseif (is_string($data['image'])) {
            // すでに string ならそのまま
        } else {
            $data['image'] = null;
        }

        return $data;
    }
}
