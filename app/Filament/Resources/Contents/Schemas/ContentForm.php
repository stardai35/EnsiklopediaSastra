<?php

namespace App\Filament\Resources\Contents\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('cat_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->searchable()
                    ->required(),
                Select::make('title_id')
                    ->relationship('lemma', 'name')
                    ->label('Title (Lemma)')
                    ->searchable()
                    ->required(),
                TextInput::make('year'),
                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->required(),
            ]);
    }
}
