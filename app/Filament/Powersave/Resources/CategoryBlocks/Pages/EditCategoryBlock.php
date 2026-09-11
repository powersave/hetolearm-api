<?php

namespace App\Filament\Powersave\Resources\CategoryBlocks\Pages;

use App\Filament\Powersave\Resources\CategoryBlocks\CategoryBlockResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCategoryBlock extends EditRecord
{
    protected static string $resource = CategoryBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
