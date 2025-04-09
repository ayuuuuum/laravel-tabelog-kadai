<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('カテゴリー名')
                ->required()
                ->maxLength(255),
            
                Textarea::make('description')
                ->label('カテゴリーの説明')
                ->maxLength(500)
                ->required(),

                FileUpload::make('image')
                ->label('店舗画像')
                ->image()
                ->directory('img') // S3のimgフォルダに保存
                ->disk('s3')  
                ->visibility('public') // 公開設定
                ->preserveFilenames() // 元ファイル名保つ
                ->dehydrateStateUsing(fn ($state) => $state) 
                ->dehydrated(true)
                ->getUploadedFileNameForStorageUsing(function ($file) {
                    return 'img/' . $file->getClientOriginalName(); // 明示的に保存パスを返す
                })
                ->required()
                ->maxFiles(1) // ← これで複数防止
                ->multiple(false),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('カテゴリー名')->sortable()->searchable(), // 検索
                ImageColumn::make('image')->label('画像'), 
                TextColumn::make('created_at')->label('作成日')->dateTime()->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }    
}
