<?php

namespace App\Filament\Powersave\Resources\HeroVideos\Pages;

use App\Filament\Powersave\Resources\HeroVideos\HeroVideoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageHeroVideos extends ManageRecords
{
    protected static string $resource = HeroVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
