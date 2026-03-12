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
        if (! Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_number')->unique();
                $table->string('customer_email');
                $table->string('customer_phone');
                $table->string('customer_first_name');
                $table->string('customer_last_name');
                $table->text('shipping_address');
                $table->string('shipping_apartment')->nullable();
                $table->string('shipping_city');
                $table->string('shipping_state');
                $table->string('shipping_zip');
                $table->string('shipping_country');
                $table->string('shipping_method');
                $table->string('payment_method');
                $table->decimal('subtotal', 10, 2)->default(0);
                $table->decimal('shipping_cost', 10, 2)->default(0);
                $table->decimal('tax', 10, 2)->default(0);
                $table->decimal('discount', 10, 2)->default(0);
                $table->decimal('total', 10, 2)->default(0);
                $table->text('notes')->nullable();
                $table->string('status')->default('pending');
                $table->string('payment_status')->default('pending');
                $table->string('transaction_id')->nullable();
                $table->timestamps();
            });
        }

        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                if (! Schema::hasColumn('order_items', 'order_id')) {
                    $table->foreignId('order_id')->nullable()->after('id');
                }

                if (! Schema::hasColumn('order_items', 'product_id')) {
                    $table->foreignId('product_id')->nullable()->after('order_id');
                }

                if (! Schema::hasColumn('order_items', 'product_name')) {
                    $table->string('product_name')->after('product_id');
                }

                if (! Schema::hasColumn('order_items', 'price')) {
                    $table->decimal('price', 10, 2)->default(0)->after('product_name');
                }

                if (! Schema::hasColumn('order_items', 'quantity')) {
                    $table->unsignedInteger('quantity')->default(1)->after('price');
                }

                if (! Schema::hasColumn('order_items', 'subtotal')) {
                    $table->decimal('subtotal', 10, 2)->default(0)->after('quantity');
                }
            });

            Schema::table('order_items', function (Blueprint $table) {
                $foreignKeys = Schema::getForeignKeys('order_items');
                $foreignColumns = collect($foreignKeys)
                    ->map(fn (array $foreignKey) => $foreignKey['columns'][0] ?? null)
                    ->filter()
                    ->values()
                    ->all();

                if (Schema::hasColumn('order_items', 'order_id') && ! in_array('order_id', $foreignColumns, true)) {
                    $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
                }

                if (Schema::hasColumn('order_items', 'product_id') && ! in_array('product_id', $foreignColumns, true)) {
                    $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                $foreignKeys = Schema::getForeignKeys('order_items');
                $foreignColumns = collect($foreignKeys)
                    ->map(fn (array $foreignKey) => $foreignKey['columns'][0] ?? null)
                    ->filter()
                    ->values()
                    ->all();

                if (in_array('order_id', $foreignColumns, true)) {
                    $table->dropForeign(['order_id']);
                }

                if (in_array('product_id', $foreignColumns, true)) {
                    $table->dropForeign(['product_id']);
                }
            });

            Schema::table('order_items', function (Blueprint $table) {
                $columnsToDrop = [];

                foreach (['order_id', 'product_id', 'product_name', 'price', 'quantity', 'subtotal'] as $column) {
                    if (Schema::hasColumn('order_items', $column)) {
                        $columnsToDrop[] = $column;
                    }
                }

                if ($columnsToDrop !== []) {
                    $table->dropColumn($columnsToDrop);
                }
            });
        }

        Schema::dropIfExists('orders');
    }
};
