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
        Schema::create('intelligences', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('supported_by');
            $table->enum('Former_member', ['بەڵێ', 'نەخێر تازە پەیوەندیکردوە']);
            $table->string('party');
            $table->date('Date_connection');
            $table->tinyInteger('Travel')->default(0)->comment('0=no, 1=yes');
            $table->string('Reason_travelling')->nullable();
            $table->tinyInteger('another_passport')->default(0)->comment('0=no, 1=yes');
            $table->string('country_passport')->nullable();
            $table->string('attach');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intelligences');
    }
};
