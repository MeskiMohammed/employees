<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('freelancer_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('price');
            $table->boolean('status');
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('freelancer_projects');
    }
};
