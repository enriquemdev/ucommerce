<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VariationGroupResource\Pages;
use App\Filament\Resources\VariationGroupResource\RelationManagers;
use App\Models\VariationGroup;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VariationGroupResource extends Resource
{
    protected static ?string $model = VariationGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $recordTitleAttribute = 'product_id';
    protected static ?string $modelLabel = 'Agrupación de Variantes';
    protected static ?string $pluralModelLabel = 'Agrupaciones de Variantes';
    protected static ?string $navigationLabel = 'Agrupaciones de Variantes';


    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $slug = 'products/variation_group';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'id')
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->required(),
                Forms\Components\TextInput::make('weight')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.id'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('weight'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime(),
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
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVariationGroups::route('/'),
            'create' => Pages\CreateVariationGroup::route('/create'),
            'view' => Pages\ViewVariationGroup::route('/{record}'),
            'edit' => Pages\EditVariationGroup::route('/{record}/edit'),
            'variation_group'         => Pages\ListVariationGroups::route('/{record}'),
            'variation_group.create'  => Pages\CreateVariationGroup::route('/{record}/create'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        // return parent::getEloquentQuery()
        //     ->withoutGlobalScopes([
        //         SoftDeletingScope::class,
        //     ]);

        return parent::getEloquentQuery()->where('product_id', request('record'));
    }
}
