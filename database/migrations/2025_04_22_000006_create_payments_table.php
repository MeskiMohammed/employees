<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('payment_type_id')->constrained();
            $table->double('gross');
            $table->double('cnss')->nullable();
            $table->integer('hours')->nullable();
            $table->double('tax_rate')->nullable();
            $table->double('income_tax')->nullable();
            $table->double('net');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('payments');
    }
};
