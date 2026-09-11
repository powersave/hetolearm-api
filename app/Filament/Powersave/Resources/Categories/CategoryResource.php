<?php

namespace App\Filament\Powersave\Resources\Categories;

use App\Filament\Powersave\Resources\Categories\Pages;
use App\Filament\Powersave\Resources\Categories\RelationManagers\BlocksRelationManager;
use App\Models\Category;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Категории';

    protected static ?string $modelLabel = 'Категория';

    protected static ?string $pluralModelLabel = 'Категории';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                TextInput::make('body_part')
                    ->label('Часть тела')
                    ->maxLength(255),

                Select::make('parent_id')
                    ->label('Родительская категория')
                    ->relationship('parent', 'name')
                    ->nullable()
                    ->searchable()
                    ->preload(),

                TextInput::make('sort_order')
                    ->label('Порядок сортировки')
                    ->numeric()
                    ->default(0),

                // НОВОЕ ПОЛЕ: Главное изображение для центрального блока
                FileUpload::make('main_image')
                    ->label('Главное изображение категории (для центрального блока)')
                    ->disk('public')
                    ->directory('categories/main')
                    ->image()
                    ->maxSize(5120)
                    ->columnSpanFull(),

                FileUpload::make('background_image')
                    ->label('Фоновое изображение секции')
                    ->disk('public')
                    ->visibility('public')
                    ->directory('categories/backgrounds')
                    ->image()
                    ->maxSize(5120)
                    ->columnSpanFull(),

                // НОВОЕ ПОЛЕ: Прозрачность подложки
                \Filament\Forms\Components\Slider::make('background_opacity')
                    ->label('Затемнение фона (0% = прозрачно, 100% = чёрный)')
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(5)
                    ->default(30)
                    ->columnSpanFull(),

                RichEditor::make('content')
                    ->label('Текст категории')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'link',
                        'h2',
                        'h3',
                        'bulletList',
                        'orderedList',
                        'undo',
                        'redo',
                    ]),

                Toggle::make('is_active')
                    ->label('Активно')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Название')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('body_part')
                    ->label('Часть тела'),

                // Добавлено главное изображение в таблицу для наглядности
                ImageColumn::make('main_image')
                    ->label('Главное фото')
                    ->disk('public'),

                ImageColumn::make('background_image')
                    ->label('Фон')
                    ->disk('public'),

                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),

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
            ])
            ->defaultSort('sort_order');
    }

    public static function getRelations(): array
    {
        return [
            BlocksRelationManager::class,
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