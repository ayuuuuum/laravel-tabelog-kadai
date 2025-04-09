<?php

namespace App\Filament\Resources\ShopResource\Pages;

use App\Filament\Resources\ShopResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateShop extends CreateRecord
{
    protected static string $resource = ShopResource::class;

    /*public function mutateFormDataBeforeCreate(array $data): array
    {
        \Log::debug('🟢 mutateFormDataBeforeCreate 中身', $data);

        return $data;
    }*/
}
