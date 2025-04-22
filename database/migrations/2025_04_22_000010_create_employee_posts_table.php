<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('employee_posts', function (Blueprint $table) {
            $table->id();
            $table->string('post');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('employee_posts');
    }
};
