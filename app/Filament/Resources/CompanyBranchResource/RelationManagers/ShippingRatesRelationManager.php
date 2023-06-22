<?php

namespace App\Filament\Resources\CompanyBranchResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\DB;
use Livewire\Component as Livewire;

class ShippingRatesRelationManager extends RelationManager
{
    protected static string $relationship = 'shipping_rates';

    protected static ?string $recordTitleAttribute = 'destiny_department_id';

    protected static ?string $inverseRelationship = 'company_branch'; 


    protected static ?string $modelLabel = 'Tarifa de envío';
    protected static ?string $pluralModelLabel = 'Tarifas de envío';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Necesitaba que aqui solo se pudiera seleccionar los departamentos que no tuvieran registro en shipping rates siendo de la misma Company Branch
                Select::make('destiny_department_id') //Entonces hago un select de la columna de la tabla padre que tiene relacion con el departamento 
                    ->relationship('department', 'cat_departments.name', function (Builder $query, RelationManager $livewire) {
                         $query->whereDoesntHave('shipping_rates', function ($subquery) use ($livewire) {
                            $subquery->where('company_branch_id', '=', $livewire->ownerRecord->id);
                        });
                    })
                    // Luego le paso la relacion que tiene con la tabla de shipping rates (funcion del modelo, y el nombre de la columna que quiero que se muestre)
                    // Y la diferencia ahora es que se le pasa un Closure para poder modificar la query y hacer el filtro mencionado, que tambien se le pasa el  RelationManager $livewire al que tienen acceso todos los metodos Filament
                    // Luego se usa un whereDoesntHave en la modificacion del query y a este se le pasa la relacion que tiene el modelo padre (Company Branch con el de la relacion que es Shipping Rates)
                    // Esta funcion lo que hace es buscar registros que no cuenten con un registro hijo de la otra tabla, pero hay que filtrar aun debido a que el filtro es por cada Company Branch
                    // Entonces se hace otro Closure para modificar la query y se le pasa el $livewire para obtener el id del Company Branch y poder filtrar
                    // Y al subquery modificador es donde se compara especificamente el registro del company branch que se desea y no con todos.
                    //  $livewire->ownerRecord accede a la fila del padre de esta relacion que es el CompanyBranch, ya con eso se accede a su id con normalidad
                    ->required()->label('Departamento'),
                TextInput::make('rate_per_pound')
                    ->required()
                    ->numeric()
                    ->prefix('USD $')
                    ->mask(fn (TextInput\Mask $mask) => $mask
                        ->numeric()
                        ->decimalPlaces(2) // Set the number of digits after the decimal point.
                        ->decimalSeparator('.') // Add a separator for decimal numbers.
                        ->minValue(0) // Set the minimum value that the number can be.
                        ->padFractionalZeros() // Pad zeros at the end of the number to always maintain the maximum number of decimal places.
                        ->thousandsSeparator(','), // Add a separator for thousands.
                    )
                    ->label('Tarifa por libra'),
                TextInput::make('days_delivery')
                    ->required()
                    ->numeric()
                    ->suffix('Días')
                    ->mask(fn (TextInput\Mask $mask) => $mask
                        ->numeric()
                        ->integer() // Set the number of digits after the decimal point.
                        ->minValue(0) // Set the minimum value that the number can be.
                        ->maxValue(100) // Set the maximum value that the number can be.
                        ->thousandsSeparator(','), // Add a separator for thousands.
                    )->label('Días de entrega'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('destiny_department_id'),
                Tables\Columns\TextColumn::make('department.name')
                    ->searchable()
                    ->label('Departamento'),
                Tables\Columns\TextColumn::make('rate_per_pound')->label('Tarifa por libra'),
                Tables\Columns\TextColumn::make('days_delivery')->label('Días de entrega'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }   
    
}
