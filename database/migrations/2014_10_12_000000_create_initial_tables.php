<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Original User Table

        // Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('password');
        //     $table->rememberToken();
        //     $table->foreignId('current_team_id')->nullable();
        //     $table->string('profile_photo_path', 2048)->nullable();
        //     $table->timestamps();
        // });

        // Schema::create('users_type', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('type');
        //     $table->string('description')->nullable();
        //     $table->timestamps();
        // });

        // *** Tablas de catalogo ***
        Schema::create('cat_departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes(); //This needs to be here to add softDeletes
        });

        Schema::create('company_branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('cat_department_id')->constrained('cat_departments');
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_branch_id')->constrained('company_branches'); // from here   
            $table->foreignId('destiny_department_id')->constrained('cat_departments'); // To here
            $table->decimal('rate_per_pound', 8, 2);
            $table->integer('days_delivery'); // How many days it takes to deliver
            //$table->decimal('fixed_rate', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->tinyInteger('is_staff')->default(0); // 0 for Client, 1 for Staff
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('adresses_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('department_id')->constrained('cat_departments');
            $table->string('address');
            $table->string('phone_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('package_receivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // the receiver is for a user
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->timestamps();
            $table->softDeletes();
        });

        // *** Tablas de productos ***

        Schema::create('parent_product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('parent_category_name');
            $table->string('parent_description')->nullable();
            $table->foreignId('user_added')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });

        // ej: clothing
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_category_id')->constrained('parent_product_categories');
            $table->string('category_name');
            $table->string('description')->nullable();
            $table->boolean('shipping_price_weight')->default(true); // true is ship price is based on product pounds, false if it is a fixed categorie price
            $table->timestamps();
            $table->softDeletes();
        });

        // ej: color
        Schema::create('specifications', function (Blueprint $table) {
            $table->id();
            $table->string('specification');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // ej: red, blue, green
        Schema::create('specification_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specification_id')->constrained('specifications');
            $table->string('option');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        //  mid table between product_categories and specifications
        Schema::create('categories_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prod_category_id')->constrained('product_categories');
            $table->foreignId('specification_id')->constrained('specifications');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('product_category_id')->constrained('product_categories');
            $table->string('description');
            $table->decimal('price', 10, 2);
            $table->decimal('weight', 10, 2);
            $table->boolean('state')->default(true); // true is active, false is inactive
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('specification_id')->constrained('specifications');
            $table->foreignId('option_id')->constrained('specification_options');
            $table->timestamps();
            $table->softDeletes();
        });

        // This is for when is the same product(but with variations, ej: size)
        // Creo que debi haber creado una tabla que sea variations y luego conectarla muchos a muchos con categorias por que puede que el size sea para varias catergorias
        //AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('product_category_id')->constrained('product_categories');
            $table->string('variation_name');
            $table->string('variation_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
        // Tabla relacion muchos a muchos entre product_categories y variations
        Schema::create('product_category_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->constrained('product_categories');
            $table->foreignId('variation_id')->constrained('variations');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('variations_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variation_id')->constrained('variations');
            $table->string('variation_option');
            $table->timestamps();
            $table->softDeletes();
        });

        // Mid table bertween products and variation options (product may have multiple variation RAM and Space for example)\
        //So first we create a variation agrupation, and then in a child table the different variation option values

        //Tabla agrupa todos los valores de las variaciones por producto 1 a muchos con producto
        Schema::create('variations_products_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('variations_products_details', function (Blueprint $table) {
            $table->id();
            // Aqui me comi el id de la tabla anterior (la de grupos)
            //ya
            $table->foreignId('variation_group_id')->constrained('variations_products_group');
            $table->foreignId('variation_option_id')->constrained('variations_options');
            $table->timestamps();
            $table->softDeletes();
        });

        //Company branches and products to know quantity available all over the branches
        Schema::create('branch_product_variation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_branch_id')->constrained('company_branches');
            // En teoria no necesitaria el producto si guardo el grupo de variaciones de un producto pero hay que ver
            $table->foreignId('product_id')->constrained('products');
            //El siguiente constraint deberia ser con el grupo de variaciones de un producto para obtener el producto unico con x variaciones
            $table->foreignId('variation_group_id')->constrained('variations_products_group')->nullable(); //Only if it has variations
            $table->integer('available_quantity')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });


        // Purchases tables
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->decimal('extra_costs', 10, 2)->default(0);
            $table->string('receipt_uri')->nullable();
            $table->text('purchase_note')->nullable();
            $table->foreignId('user_registered')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases');
            $table->foreignId('product_id')->constrained('products');
            // Add the variation group id here As this is the definitive identifier of a product
            $table->foreignId('variation_group_id')->constrained('variations_products_group')->nullable(); //Only if it has variations
            $table->integer('purchase_quantity')->default(0);
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // The total of the quantities here must match with the purchase detail parent
        Schema::create('purchase_details_branch', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_detail_id')->constrained('purchase_details');
            $table->foreignId('company_branch_id')->constrained('company_branches');
            $table->integer('quantity_to_branch')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Sales, configs and operation like returns or damaged products are left for later
        // Also the complete buying process solicitud, aprobacion, llegada de mercaderia, etc.
        // Tambien la habilidad de cambiar de moneda, dolar - Cordoba. Por lo tanto se debe guardar el tipo de cambio en las transacciones

        // Sales tables
        Schema::create('cat_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        //The user info is null if the client is not registered, it will have a connection in another table
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->nullable();
            $table->foreignId('client_address_id')->constrained('adresses_users')->nullable();
            $table->foreignId('package_receiver_id')->constrained('package_receivers')->nullable();
            $table->foreignId('payment_method_id')->constrained('cat_payment_methods');
            $table->integer('last_4_digits')->nullable(); //If it is payed with bank card
            $table->decimal('total_discount', 10, 2)->default(0);
            $table->string('receipt_uri')->nullable();
            $table->text('sale_note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales_without_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->unique();// Relation 1 to 1
            $table->string('name');
            $table->string('phone_number');
            $table->string('email');
            $table->string('address');
            $table->foreignId('department_id')->constrained('cat_departments');

            $table->string('name_receiver')->nullable();
            $table->string('email_receiver')->nullable();
            $table->string('phone_number_receiver')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales');
            $table->foreignId('product_id')->constrained('products');
            // Add the variation group id here As this is the definitive identifier of a product
            $table->foreignId('variation_group_id')->constrained('variations_products_group')->nullable(); //Only if it has variations
            $table->integer('sale_quantity')->default(0);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('shipping_price', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // The total of the quantities here must match with the sale detail parent
        Schema::create('sale_details_branch', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_detail_id')->constrained('sale_details');
            $table->foreignId('company_branch_id')->constrained('company_branches');
            $table->integer('quantity_from_branch')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Shipping tables

        Schema::create('shipping_states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        // pending, in transit, delivered, failed

        Schema::create('shipping_branch', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales');
            $table->foreignId('company_branch_id')->constrained('company_branches');
            $table->foreignId('shipping_state_id')->constrained('shipping_states');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('shipping_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_branch_id')->constrained('shipping_branch'); //father table
            $table->foreignId('sale_detail_branch_id')->constrained('sale_details_branch');
            $table->timestamps();
            $table->softDeletes();
        });




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
