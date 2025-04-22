<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code');
            $table->string('cin')->unique();
            $table->string('profile_picture')->nullable();
            $table->string('adress')->nullable();
            $table->string('personal_num')->nullable();
            $table->string('professional_num')->nullable();
            $table->string('pin')->nullable();
            $table->string('salary')->nullable();
            $table->boolean('is_project')->default(false);
            $table->string('hours')->nullable();
            $table->string('professionalEmail')->nullable();
            $table->string('cnss')->nullable();
            $table->string('assurance')->nullable();
            $table->foreignId('operator_id')->nullable()->constrained('operators')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('status_id')->nullable()->constrained('status')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('employees');
    }
};
