<?php

namespace App\Filament\Powersave\Resources\HeroVideos;

use App\Filament\Powersave\Resources\HeroVideos\Pages\ManageHeroVideos;
use App\Models\HeroVideo;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class HeroVideoResource extends Resource
{
    protected static ?string $model = HeroVideo::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationLabel = 'Главное видео';

    protected static ?string $modelLabel = 'Главное видео';

    protected static ?string $pluralModelLabel = 'Главное видео';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('video_file')
                    ->label('Видео файл')
                    ->disk('public')
                    ->directory('hero-videos')
                    ->acceptedFileTypes(['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/webm'])
                    ->maxSize(102400) // 100 MB
                    ->columnSpanFull(),

                TextInput::make('video_url')
                    ->label('Или URL видео (YouTube, Vimeo)')
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Активно')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('video_file')
                    ->label('Файл')
                    ->limit(30)
                    ->toggleable(),

                TextColumn::make('video_url')
                    ->label('URL')
                    ->limit(30)
                    ->toggleable()
                    ->url(fn (?string $state): ?string => $state, shouldOpenInNewTab: true),

                IconColumn::make('is_active')
                    ->label('Активно')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Активно'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageHeroVideos::route('/'),
        ];
    }
}
