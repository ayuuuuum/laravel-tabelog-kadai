<?php

namespace App\Filament\Resources\ShopResource\Pages;

use App\Filament\Resources\ShopResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

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
        if (is_array($data['image']) && count($data['image']) > 0) {
            $data['image'] = $data['image'][0];
        } else {
            $data['image'] = null; // または '' にするなどして空の処理
        }

        return $data;
    }
}
