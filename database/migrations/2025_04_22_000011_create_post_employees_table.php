<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('post_employees', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->date('in_date')->nullable();
            $table->date('out_date')->nullable();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('employee_post_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('post_employees');
    }
};
