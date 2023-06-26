<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductCategoryResource\Pages;
use App\Filament\Resources\ProductCategoryResource\RelationManagers;
use App\Models\ProductCategory;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $recordTitleAttribute = 'category_name';
    protected static ?string $modelLabel = 'Subcategoría de Producto';
    protected static ?string $pluralModelLabel = 'Subcategorías de Productos';
    protected static ?string $navigationLabel = 'Subcategorías de Productos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('parent_category_id') // Columna de la tabla que tiene el foreign key
                    ->required()
                    ->relationship('parent_category', 'parent_product_categories.parent_category_name') // Nombre de la relación en el modelo, valor de la columna de la tabla que se mostrara enel select
                    ->label('Categoría Padre'),
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
                Tables\Columns\TextColumn::make('category_name')
                    ->searchable()
                    ->sortable()
                    ->label('Nombre Subcategoría'),
                Tables\Columns\TextColumn::make('parent_category.parent_category_name')
                    ->searchable()
                    ->sortable()
                    ->label('Categoría Padre'),
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
            RelationManagers\SpecificationsRelationManager::class,
            RelationManagers\VariationsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductCategories::route('/'),
            'create' => Pages\CreateProductCategory::route('/create'),
            'view' => Pages\ViewProductCategory::route('/{record}'),
            'edit' => Pages\EditProductCategory::route('/{record}/edit'),
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
