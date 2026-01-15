<?php

namespace App\Filament\Resources\Media\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('type_id')
                    ->required()
                    ->numeric(),
                TextInput::make('content_id')
                    ->required()
                    ->numeric(),
                TextInput::make('position_id')
                    ->required()
                    ->numeric(),
                Textarea::make('link')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('caption')
                    ->columnSpanFull(),
            ]);
    }
}
