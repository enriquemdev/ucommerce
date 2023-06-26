<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VariationResource\Pages;
use App\Filament\Resources\VariationResource\RelationManagers;
use App\Models\Variation;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VariationResource extends Resource
{
    protected static ?string $model = Variation::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $recordTitleAttribute = 'variation_name';
    protected static ?string $modelLabel = 'Variante de Producto';
    protected static ?string $pluralModelLabel = 'Variantes del Producto';
    protected static ?string $navigationLabel = 'Variantes de Productos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('variation_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nombre de la Variante del Producto'),
                Forms\Components\TextInput::make('variation_description')
                    ->maxLength(255)
                    ->label('Descripción'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('variation_name')
                    ->searchable()
                    ->sortable()
                    ->label('Nombre de la Variante del Producto'),
                Tables\Columns\TextColumn::make('variation_description')
                    ->searchable()
                    ->sortable()
                    ->label('Descripción'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->label('Fecha de Creación'),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime(),
                // Tables\Columns\TextColumn::make('deleted_at')
                //     ->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\VariationOptionsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVariations::route('/'),
            'create' => Pages\CreateVariation::route('/create'),
            'view' => Pages\ViewVariation::route('/{record}'),
            'edit' => Pages\EditVariation::route('/{record}/edit'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
