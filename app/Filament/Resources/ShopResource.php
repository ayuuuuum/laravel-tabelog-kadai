<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShopResource\Pages;
use App\Filament\Resources\ShopResource\RelationManagers;
use App\Models\Shop;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Imports\ShopsImport;// ← インポートクラス
use Maatwebsite\Excel\Facades\Excel;

class ShopResource extends Resource
{
    protected static ?string $model = Shop::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    //店舗作成フォームを表示
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('店舗名')
                ->required()
                ->maxLength(255),
            
                Textarea::make('description')
                ->label('店舗の説明')
                ->maxLength(500),

                FileUpload::make('image')
                ->label('店舗画像')
                ->image()
                ->directory('shops'), //`storage/app/public/shops` に保存

                Toggle::make('recommend_flag') // おすすめフラグ
                ->label('おすすめ店舗'),

                TimePicker::make('open_time')
                ->label('開店時間')
                ->required(),

                TimePicker::make('close_time')
                ->label('閉店時間')
                ->required(),

                TextInput::make('price') 
                ->label('価格')
                ->numeric()
                ->prefix('¥') 
                ->required(),

                TextInput::make('min_price') 
                ->label('最小価格')
                ->numeric()
                ->prefix('¥') 
                ->required(),

                TextInput::make('max_price') 
                ->label('最大価格')
                ->numeric()
                ->prefix('¥') 
                ->required(),

                Select::make('category_id')
                ->label('カテゴリー')
                ->relationship('category', 'name') // カテゴリーテーブルとのリレーション
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('店舗名')->sortable()->searchable(), // 検索
                ImageColumn::make('image')->label('画像'),
                TextColumn::make('price')->label('価格')->sortable()->money('JPY'), // 金額フォーマット
                TextColumn::make('min_price')->label('最小価格')->sortable()->money('JPY'),
                TextColumn::make('max_price')->label('最大価格')->sortable()->money('JPY'),
                TextColumn::make('open_time')->label('開店時間')->sortable(),
                TextColumn::make('close_time')->label('閉店時間')->sortable(),
                TextColumn::make('category_id')->label('カテゴリID')->sortable(),
                TextColumn::make('created_at')->label('作成日')->dateTime()->sortable(),
            ])

            ->filters([
                //
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('CSVインポート')
                ->form([
                    FileUpload::make('csv_file')
                        ->label('CSVファイル')
                        ->acceptedFileTypes(['text/csv'])
                        ->required(),
                ])
                ->action(function (array $data) {
                    dd($data['csv_file']); // ここでファイル情報を確認
                    Excel::import(new ShopsImport, $data['csv_file']);
                })
                ->successNotificationTitle('CSVのインポートが完了しました!'),
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
            'index' => Pages\ListShops::route('/'),
            'create' => Pages\CreateShop::route('/create'),
            'edit' => Pages\EditShop::route('/{record}/edit'),
        ];
    }
}
