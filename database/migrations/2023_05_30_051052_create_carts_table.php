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
        Schema::create('carts', function (Blueprint $table)
         {
           $table->id();
           $table->string('my_cart');
                         ##### relation_user ###
           $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
           $table->integer('total')->nullable();
           $table->timestamps();
        });
    }



    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
