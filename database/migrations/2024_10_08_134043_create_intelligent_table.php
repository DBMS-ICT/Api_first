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
        Schema::create('intelligence', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->json('supported_by');
            $table->json('Former_member');
            $table->foreignId('party_id')->constrained()->onDelete('cascade');
            $table->date('Date_connection')->nullable();
            $table->tinyInteger('Travel')->default(0)->comment('0=no, 1=yes');
            $table->json('Reason_travelling')->nullable();
            $table->tinyInteger('another_passport')->default(0)->comment('0=no, 1=yes');
            $table->json('country_passport')->nullable();
            $table->string('attach');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('family');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intelligence');
    }
};
