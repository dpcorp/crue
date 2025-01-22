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
        Schema::create('saturations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ips_id');

            $table->date('date');
            $table->time('time');

            $table->decimal('urgency_adults', 5, 2)->default(0);
            $table->decimal('urgency_pediatrics', 5, 2)->default(0);

            $table->decimal('hospitalization_adults', 5, 2)->default(0);
            $table->decimal('hospitalization_obstetrics', 5, 2)->default(0);
            $table->decimal('hospitalization_pediatrics', 5, 2)->default(0);

            $table->decimal('uce_adults', 5, 2)->default(0);
            $table->decimal('uce_pediatrics', 5, 2)->default(0);
            $table->decimal('uce_neonatal', 5, 2)->default(0);

            $table->decimal('uci_adults', 5, 2)->default(0);
            $table->decimal('uci_pediatrics', 5, 2)->default(0);
            $table->decimal('uci_neonatal', 5, 2)->default(0);

            $table->timestamps();

            $table->foreign('ips_id')->references('id')->on('ips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saturations');
    }
};
