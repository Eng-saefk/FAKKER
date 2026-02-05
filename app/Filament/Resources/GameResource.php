<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Models\Game;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy'; // أيقونة الكأس أجمل
    protected static ?string $navigationLabel = 'المباريات والتحديات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('تفاصيل المباراة')
                    ->description('أدخل بيانات الفريقين ووقت اللقاء')
                    ->schema([
                        Forms\Components\TextInput::make('team_a')
                            ->label('الفريق المستضيف (A)')
                            ->required()
                            ->placeholder('مثلاً: ريال مدريد'),
                        Forms\Components\TextInput::make('team_b')
                            ->label('الفريق الضيف (B)')
                            ->required()
                            ->placeholder('مثلاً: برشلونة'),
                        Forms\Components\DateTimePicker::make('game_time')
                            ->label('موعد الانطلاق')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('حالة المباراة')
                            ->options([
                                'upcoming' => 'قادمة',
                                'live' => 'مباشر الآن',
                                'finished' => 'انتهت',
                            ])->default('upcoming')->required(),
                        Forms\Components\TextInput::make('points_win')
                            ->label('جائزة التوقع الصحيح (نقاط)')
                            ->numeric()
                            ->default(100)
                            ->suffix('نقطة'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('team_a')
                    ->label('المستضيف')
                    ->weight('bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('team_b')
                    ->label('الضيف')
                    ->weight('bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('game_time')
                    ->label('الموعد')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'gray' => 'upcoming',
                        'warning' => 'live',
                        'success' => 'finished',
                    ]),
                Tables\Columns\TextColumn::make('points_win')
                    ->label('النقاط')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
    public function createGame()
{
    // فقط لعرض الصفحة التي سنكتب فيها بيانات المباراة
    return view('admin.create-game');
}
public function storeGame(Request $request)
{
    \App\Models\Game::create([
        'team_a' => $request->team_a,
        'team_b' => $request->team_b,
        'game_time' => $request->game_time,
        'points_win' => $request->points_win,
        'status' => 'upcoming', // الحالة الافتراضية لأي مباراة جديدة
    ]);

    return redirect('/challenges')->with('success', 'تم إضافة المباراة بنجاح! 🔥');
}
}