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
                ->image()                                  // 画像のみ許可
                ->disk('s3')                               // S3ディスクを使用
                ->directory('img')                         // バケット内のディレクトリ
                ->visibility('public')                     // 公開アクセス権
                ->preserveFilenames()                      // 元のファイル名で保存
                ->storeFileNamesIn('image_orig_name')// 元ファイル名を別カラムに保存
                ->enableDownload()                     // ダウンロードボタンを有効化（必要に応じて）
                ->nullable()                           // 必須ではないフィールド
                ->helperText('対応形式: JPG/PNG, 最大4MBまで'), 
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
