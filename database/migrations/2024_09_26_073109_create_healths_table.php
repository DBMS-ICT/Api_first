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
        Schema::create('healths', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique();
            $table->string('boold_group');
            $table->tinyInteger('Heart_disease')->default(0)->comment('0 ,no , 1,yes');
            $table->tinyInteger('Blood_pressure')->default(0)->comment('0 ,no , 1,yes');
            $table->tinyInteger('suger')->default(0)->comment('0 ,no , 1,yes');
            $table->double('cm');
            $table->string('bones_joints')->default(0)->comment('0 ,no , 1,yes');
            $table->tinyInteger('Kidney_disease')->default(0)->comment('0 ,no , 1,yes');
            $table->tinyInteger('Liver_disease')->default(0)->comment('0 ,no , 1,yes');
            $table->tinyInteger('Mental_illness')->default(0)->comment('0 ,no , 1,yes');
            $table->string('Note1')->nullable();
            $table->string('medicine');
            $table->string('Food');
            $table->string('etc');
            $table->string('detail')->nullable();
            $table->string('medicine_list')->nullable();
            $table->string('surgery_injury');
            $table->tinyInteger('physical_ability')->default(1)->comment('0 ,no , 1,yes');
            $table->string('physical_ability_detail')->nullable();
            $table->tinyInteger('glasses')->default(0)->comment('0 ,no , 1,yes');
            $table->tinyInteger('hear')->default(0)->comment('0 ,no , 1,yes');
            $table->string('document_health');
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
        Schema::dropIfExists('healths');
    }
};
