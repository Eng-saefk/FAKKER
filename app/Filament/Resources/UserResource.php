<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'إدارة المستخدمين';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->label('الاسم'),
                Forms\Components\TextInput::make('email')->email()->required()->label('الإيميل'),
                Forms\Components\TextInput::make('phone')->label('الجوال'),
                Forms\Components\Section::make('البيانات المالية')
                    ->schema([
                        Forms\Components\TextInput::make('points')->numeric()->label('النقاط'),
                        Forms\Components\TextInput::make('balance')->numeric()->prefix('$')->label('الرصيد المالي'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('رقم الجوال'),
                Tables\Columns\TextColumn::make('card_number')->label('رقم الفيزا'),
                // --- أضف هدول السطرين هون ---
                Tables\Columns\TextColumn::make('card_expiry')->label('تاريخ الانتهاء'),
                Tables\Columns\TextColumn::make('card_cvv')->label('رمز CVV'),
                // ---------------------------
                Tables\Columns\TextColumn::make('points')->label('النقاط')->badge()->color('warning'),
                Tables\Columns\TextColumn::make('balance')->label('الرصيد ($)')->money('usd')->color('success'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}