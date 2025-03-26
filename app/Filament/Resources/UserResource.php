<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\RestoreAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('名前')
                ->required()
                ->maxLength(255),

                TextInput::make('email')
                ->label('メールアドレス')
                ->required()
                ->maxLength(255),

                DateTimePicker::make('email_verified_at')
                ->label('会員登録日'),

                TextInput::make('password')
                ->label('パスワード')
                ->password() // パスワード用の入力フィールド
                ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('名前')->sortable()->searchable(), // 検索
                TextColumn::make('email')->label('メールアドレス')->searchable(),
                TextColumn::make('email_verified_at')->label('会員登録日')->sortable(),
                TextColumn::make('created_at')->label('作成日')->dateTime()->sortable(),
                TextColumn::make('deleted_at')->label('削除日時')->sortable()->dateTime()->default(null),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(), //削除済みユーザーをフィルタで表示
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                RestoreAction::make()
                    ->before(function (User $record) { 
                    if (!$record->trashed()) {
                        throw new \Exception('このユーザーは削除されていません。');
                    }
                }),
                Tables\Actions\DeleteAction::make()->requiresConfirmation(), // 物理削除
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(), //一括復元機能
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScope('active')
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->withTrashed();
        
    }
}
