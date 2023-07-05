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
        Schema::create('revision', function (Blueprint $table) {
            $table->id();
            $table->timestamp('inicio_revision')->useCurrent();
            $table->timestamp('fin_revision')->useCurrent();
            $table->string('revisor');
            $table->double('precio_revision',8,2)->default(1.00);
            $table->double('total_revision',8,2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revision');
    }
};
