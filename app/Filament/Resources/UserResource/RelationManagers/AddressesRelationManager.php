<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $recordTitleAttribute = 'address';

    protected static ?string $inverseRelationship = 'user'; 


    protected static ?string $modelLabel = 'Dirección del usuario';
    protected static ?string $pluralModelLabel = 'Direcciones del usuario';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('department_id')
                    ->required()
                    ->relationship('department', 'cat_departments.name')
                    ->label('Departamento'),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255)
                    ->label('Dirección'),
                Forms\Components\TextInput::make('phone_number')
                    ->required()
                    ->tel()
                    ->label('Teléfono'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department.name')
                    ->searchable()
                    ->sortable()
                    ->label('Ubicación'),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->sortable()
                    ->label('Dirección'),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable()
                    ->sortable()
                    ->label('Teléfono'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
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
