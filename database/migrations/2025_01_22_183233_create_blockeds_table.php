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
        Schema::create('blockeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ips_id');

            $table->date('date');
            $table->time('time');

            $table->integer('urgency_adults')->default(0);
            $table->integer('urgency_pediatrics')->default(0);

            $table->integer('hospitalization_adults')->default(0);
            $table->integer('hospitalization_obstetrics')->default(0);
            $table->integer('hospitalization_pediatrics')->default(0);

            $table->integer('uce_adults')->default(0);
            $table->integer('uce_pediatrics')->default(0);
            $table->integer('uce_neonatal')->default(0);

            $table->integer('uci_adults')->default(0);
            $table->integer('uci_pediatrics')->default(0);
            $table->integer('uci_neonatal')->default(0);

            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('ips_id')->references('id')->on('ips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blockeds');
    }
};
