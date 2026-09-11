<?php

namespace App\Filament\Powersave\Resources\CategoryBlocks\Pages;

use App\Filament\Powersave\Resources\CategoryBlocks\CategoryBlockResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategoryBlocks extends ListRecords
{
    protected static string $resource = CategoryBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
