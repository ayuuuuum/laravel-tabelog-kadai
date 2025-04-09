<?php

namespace App\Filament\Resources\ShopResource\Pages;

use App\Filament\Resources\ShopResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EditShop extends EditRecord
{
    protected static string $resource = ShopResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // 既存のパスに「img/」が含まれない場合は付与（万一の不整合に備えて）
        if (!empty($data['image']) && !str_contains($data['image'], 'img/')) {
            $data['image'] = 'img/' . $data['image'];
        }
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // 画像が差し替わった場合は古いファイルをS3から削除
        if ($this->record && $this->record->image && isset($data['image']) && $data['image'] !== $this->record->image) {
            Storage::disk('s3')->delete($this->record->image);
        }
        return $data;
    }
}
