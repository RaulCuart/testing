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
        Schema::create('dams', function (Blueprint $table) {
            $table->id(column: 'id')->autoIncrement()->primary();
            $table->enum('curso', ['primero','segundo'])->default('primero');
            $table->string('modulo',40);
            $table->string('descripcion',100);
            $table->integer('nHoras');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dams');
    }
};
