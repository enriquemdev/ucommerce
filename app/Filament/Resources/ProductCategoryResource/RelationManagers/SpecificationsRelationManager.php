<?php

namespace App\Filament\Resources\ProductCategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecificationsRelationManager extends RelationManager
{
    protected static string $relationship = 'specifications';

    protected static ?string $recordTitleAttribute = 'specification_id';

    protected static ?string $inverseRelationship = 'categories'; 
    protected static ?string $modelLabel = 'Especificación de la subcategoría';
    protected static ?string $pluralModelLabel = 'Especificaciones de la subcategoría';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('specification_id') // Columna en la tabla intermedia del Modelo Padre
                ->relationship('specification', 'specifications.specification', function (Builder $query, RelationManager $livewire) { // Relacion en el Modelo hijo, tabla.columna identificador
                     $query->whereDoesntHave('categories', function ($subquery) use ($livewire) { // Relacion en el Modelo padre, tabla.columna identificador
                        $subquery->where('prod_category_id', '=', $livewire->ownerRecord->id); // Columna de la tabla intermedia de el modelo Hijo
                    });
                }),
                // Forms\Components\Select::make('specification_id')
                //     ->relationship('specification', 'specification')//relacion, nombreColumna
                //     ->required()
                //     ->label('Especificación a relacionar'),
                Forms\Components\Textarea::make('description')
                    ->maxLength(255)
                    ->label('Descripción / Nota'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('specification.specification')//relacion.nombreColumna
                    ->searchable()
                    ->sortable()
                    ->label('Nombre especificación'),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                    ->label('Descripción de la especificación en esta categoría'),
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
