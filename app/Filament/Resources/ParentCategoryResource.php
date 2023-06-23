<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParentCategoryResource\Pages;
use App\Filament\Resources\ParentCategoryResource\RelationManagers;
use App\Models\ParentCategory;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParentCategoryResource extends Resource
{
    protected static ?string $model = ParentCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $recordTitleAttribute = 'parent_category_name';
    protected static ?string $modelLabel = 'Categoría Padre';
    protected static ?string $pluralModelLabel = 'Categorías Padre';
    protected static ?string $navigationLabel = 'Categorías Padre';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('user_added')
                //     ->required(),
                Forms\Components\TextInput::make('parent_category_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nombre de la Categoría Padre'),
                Forms\Components\TextInput::make('parent_description')
                    ->maxLength(255)
                    ->label('Descripción'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_added'),
                Tables\Columns\TextColumn::make('parent_category_name'),
                Tables\Columns\TextColumn::make('parent_description'),
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
            'index' => Pages\ListParentCategories::route('/'),
            'create' => Pages\CreateParentCategory::route('/create'),
            'view' => Pages\ViewParentCategory::route('/{record}'),
            'edit' => Pages\EditParentCategory::route('/{record}/edit'),
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
