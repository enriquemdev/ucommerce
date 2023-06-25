<?php

namespace App\Filament\Resources\ParentCategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductCategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'product_categories';

    protected static ?string $recordTitleAttribute = 'category_name';

    protected static ?string $inverseRelationship = 'parent_category';
    protected static ?string $modelLabel = 'Subcategoría de producto';
    protected static ?string $pluralModelLabel = 'Subcategorías de productos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('category_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nombre de la subcategoría'),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255)
                    ->label('Descripción'),
                Forms\Components\Checkbox::make('shipping_price_weight')
                    ->inline(false)
                    ->label('Calcular el precio de envío en base al peso en libras'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //Tables\Columns\TextColumn::make('category_name'),
                Tables\Columns\TextColumn::make('category_name')
                    ->searchable()
                    ->sortable()
                    ->label('Nombre Subcategoría'),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                    ->label('Descripción'),
                Tables\Columns\IconColumn::make('shipping_price_weight') //Aqui podemos poner un filtro
                    ->boolean()
                    ->searchable()
                    ->sortable()
                    ->label('Precio de envío basado en peso'),
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
