<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_items', function (Blueprint $table) {
            $table->id();
            $table->string('itemName');
            $table->string('itemDueDate');
            $table->float('itemPreferedStoreID');
            $table->float('price');
            $table->float('numberNeeded');
            $table->timestamps();
        });
        Schema::create('shops', function(Blueprint $table) {
            $table->id();
            $table->string('shopName');
            $table->float('shopDistance');
            $table->string('lastVisit');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_items');
    }
};
