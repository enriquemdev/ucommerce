<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Usuario';
    protected static ?string $pluralModelLabel = 'Usuarios';
    protected static ?string $navigationLabel = 'Usuarios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nombre'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->label('Email'),
                Forms\Components\Toggle::make('is_staff')
                    ->required()
                    ->label('Es Staff'),
                // Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->label('Contraseña'),
                // Forms\Components\Textarea::make('two_factor_secret')
                //     ->maxLength(65535),
                // Forms\Components\Textarea::make('two_factor_recovery_codes')
                //     ->maxLength(65535),
                // Forms\Components\DateTimePicker::make('two_factor_confirmed_at'),
                // Forms\Components\TextInput::make('current_team_id'),
                // Forms\Components\TextInput::make('profile_photo_path')
                //     ->maxLength(2048),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('Email'),
                Tables\Columns\IconColumn::make('is_staff')
                    ->boolean()
                    ->sortable()
                    ->label('Es Staff'),
                // Tables\Columns\TextColumn::make('email_verified_at')
                //     ->dateTime(),
                // Tables\Columns\TextColumn::make('two_factor_secret'),
                // Tables\Columns\TextColumn::make('two_factor_recovery_codes'),
                // Tables\Columns\TextColumn::make('two_factor_confirmed_at')
                //     ->dateTime(),
                // Tables\Columns\TextColumn::make('current_team_id'),
                // Tables\Columns\TextColumn::make('profile_photo_path'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Creado en'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Actualizado en'),
                // Tables\Columns\TextColumn::make('deleted_at')
                //     ->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Filter::make('is_staff')
                    ->query(fn (Builder $query): Builder => $query->where('is_staff', 1))
                    ->label('Mostrar solo Staff')
            ],
            // layout: Layout::AboveContent,
            )
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
            RelationManagers\AddressesRelationManager::class,
            RelationManagers\PackageReceiverRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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
