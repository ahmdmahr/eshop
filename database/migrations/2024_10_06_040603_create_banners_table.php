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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            /*
             - string up to 255 char
             - text up to 65,535 char
            */
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            // enum data type helps enforce data integrity by limiting the possible values for a column
            $table->enum('condition',['banner','promotion'])->default('banner');
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
