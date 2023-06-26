<?php

namespace App\Filament\Resources\ProductCategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VariationsRelationManager extends RelationManager
{
    protected static string $relationship = 'variations';

    protected static ?string $recordTitleAttribute = 'variation_id';

    protected static ?string $inverseRelationship = 'subcategories'; 
    protected static ?string $modelLabel = 'Variante de la subcategoría';
    protected static ?string $pluralModelLabel = 'Variantes de la subcategoría';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('variation_id')
                //     ->relationship('variation', 'variation_name')//relacion, nombreColumna
                //     ->required()
                //     ->label('Variante de producto a relacionar con la subcategoría'),

                Forms\Components\Select::make('variation_id') // Columna en la tabla intermedia del Modelo Padre
                    ->relationship('variation', 'variations.variation_name', function (Builder $query, RelationManager $livewire) { // Relacion en el Modelo hijo, tabla.columna identificador
                         $query->whereDoesntHave('subcategories', function ($subquery) use ($livewire) { // Relacion en el Modelo padre
                            $subquery->where('product_category_id', '=', $livewire->ownerRecord->id); // Columna de la tabla intermedia de el modelo Contrario
                        });
                    }),
                // Forms\Components\Textarea::make('description')
                //     ->maxLength(255)
                //     ->label('Descripción / Nota'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('variation.variation_name')//relacion.nombreColumna
                    ->searchable()
                    ->sortable()
                    ->label('Nombre Variante'),
                // Tables\Columns\TextColumn::make('description')
                //     ->searchable()
                //     ->sortable()
                //     ->label('Descripción de la Variante en esta categoría'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->label('Creado en'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
            ]);
    }    
    
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
