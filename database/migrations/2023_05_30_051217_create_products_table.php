<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->double('price_product');
            $table->integer('views')->default(0)->min(0);
            $table->string('description');
            $table->integer('count');
             ### relation_user ###
             $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            //      ### relation_cart ###
            // $table->foreignId('cart_id')->constrained('carts')->cascadeOnDelete;
            // $table->timestamps();
                    ### relation_subcategory ###
            $table->foreignId('subcategory_id')->constrained('sub_categories')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('contact');
        Schema::dropIfExists('groups');


        //$table->dropColumn('user_id');
    }
}
