<?php

namespace App\Filament\Resources\SpecificationResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecificationOptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'specification_options';

    protected static ?string $recordTitleAttribute = 'option';

    protected static ?string $inverseRelationship = 'specification'; 
    protected static ?string $modelLabel = 'Opción de la especificación';
    protected static ?string $pluralModelLabel = 'Opciones de la especificación';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('option')
                    ->required()
                    ->maxLength(255)
                    ->label('Nombre de la opción'),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255)
                    ->label('Descripción'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('option')
                    ->searchable()
                    ->sortable()
                    ->label('Nombre de la opción'),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                    ->label('Descripción'),
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
