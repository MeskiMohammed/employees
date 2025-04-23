<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('pending');
            $table->foreignId('reason_id')->constrained();
            $table->foreignId('employee_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('leaves');
    }
};
