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
        Schema::create('out_of_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ips_id');
            $table->date('date');
            $table->time('time');
            $table->integer('quantity')->default(0);
            $table->text('reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('out_of_services');
    }
};
