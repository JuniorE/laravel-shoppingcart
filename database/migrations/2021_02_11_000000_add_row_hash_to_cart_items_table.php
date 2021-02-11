<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AddRowHashToCartItemsTable extends Migration {
    /**
     * Run the migration
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_items', function(Blueprint $table) {
            $table->string("row_hash")->nullable();
        });
    }

    /**
     * Reverse the migration
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_shipping_rates');
    }
}
