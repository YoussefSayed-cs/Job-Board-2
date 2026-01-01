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
        Schema::create('companies', function (Blueprint $table) {
           $table->uuid('id')->primary();
           $table->string('name');
           $table->string('address');
           $table->string('industry');
           $table->string('website') ->nullable();
           $table->string('description');  
           $table->timestamps();
           $table->softDeletes();

           //relations
           $table->uuid('ownerID');
           $table->foreign('ownerID')->references('id')->on('users')->onDelete('restrict');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_companies');
    }
};
