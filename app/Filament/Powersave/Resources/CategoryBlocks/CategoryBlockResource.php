<?php

namespace App\Filament\Powersave\Resources\CategoryBlocks;

use App\Filament\Powersave\Resources\CategoryBlocks\Pages;
use App\Models\CategoryBlock;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class CategoryBlockResource extends Resource
{
    protected static ?string $model = CategoryBlock::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Блоки категорий';

    protected static ?string $modelLabel = 'Блок категории';

    protected static ?string $pluralModelLabel = 'Блоки категорий';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

Select::make('category_id')
    ->label('Категория')
    ->relationship('category', 'name')
    ->required()
    ->searchable()
	    ->preload(),


                TextInput::make('title')
                    ->label('Заголовок')
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Описание')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Изображение карточки')
                    ->disk('public')
                    ->directory('category-blocks')
                    ->image()
                    ->maxSize(5120)
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->label('Порядок сортировки')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Категория')
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Заголовок')
                    ->limit(30),

                ImageColumn::make('image')
                    ->label('Изображение')
                    ->disk('public'),

                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Категория')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategoryBlocks::route('/'),
            'create' => Pages\CreateCategoryBlock::route('/create'),
            'edit' => Pages\EditCategoryBlock::route('/{record}/edit'),
        ];
    }
}