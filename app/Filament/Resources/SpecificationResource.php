<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpecificationResource\Pages;
use App\Filament\Resources\SpecificationResource\RelationManagers;
use App\Models\Specification;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecificationResource extends Resource
{
    protected static ?string $model = Specification::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $recordTitleAttribute = 'specification';
    protected static ?string $modelLabel = 'Especificación';
    protected static ?string $pluralModelLabel = 'Especificaciones';
    protected static ?string $navigationLabel = 'Especificaciones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('specification')
                    ->required()
                    ->maxLength(255)
                    ->label('Nombre de la Especificación'),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255)
                    ->label('Descripción'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('specification')
                    ->searchable()
                    ->sortable()
                    ->label('Nombre Especificación'),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                    ->label('Descripción'),
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
            //
            RelationManagers\SpecificationOptionsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpecifications::route('/'),
            'create' => Pages\CreateSpecification::route('/create'),
            'view' => Pages\ViewSpecification::route('/{record}'),
            'edit' => Pages\EditSpecification::route('/{record}/edit'),
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
