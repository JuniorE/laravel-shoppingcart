<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ChangeQuantityToDecimalOnCartItemsTable extends Migration {
    /**
     * Run the migration
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_items', function(Blueprint $table) {
            $table->decimal("quantity", 4)->change();
        });
    }

    /**
     * Reverse the migration
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
