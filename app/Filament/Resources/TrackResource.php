<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrackResource\Pages;
use App\Models\Track;
use App\Models\Artist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

class TrackResource extends Resource
{
    protected static ?string $model = Track::class;

    protected static ?string $navigationIcon = 'heroicon-o-musical-note';
    
    protected static ?string $navigationLabel = 'Brani';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('artist_id')
                    ->label('Artista')
                    ->relationship('artist', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                
                TextInput::make('title')
                    ->label('Titolo Brano')
                    ->required(),
                
                FileUpload::make('audio_path')
                    ->label('File Audio (MP3/WAV)')
                    ->required()
                    ->directory('tracks-audio')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/wav', 'audio/x-wav'])
                    ->maxSize(51200), // Limite a 50MB
                
                FileUpload::make('cover_path')
                    ->label('Cover Singolo')
                    ->image()
                    ->directory('tracks-covers'),
                
                Toggle::make('is_featured')
                    ->label('Metti in evidenza nel Player')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_path')
                    ->label('Cover')
                    ->square(),
                TextColumn::make('title')
                    ->label('Titolo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('artist.name')
                    ->label('Artista')
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->label('In evidenza')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Caricato il')
                    ->dateTime()
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTracks::route('/'),
            'create' => Pages\CreateTrack::route('/create'),
            'edit' => Pages\EditTrack::route('/{record}/edit'),
        ];
    }
}
