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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->addColumn('string','rut');
            $table->addColumn('string','nombre');
            $table->addColumn('string','aMaterno');
            $table->addColumn('string','aPaterno');
            $table->addColumn('string','email');
            $table->addColumn('string','password');
            $table->timestamps();
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
