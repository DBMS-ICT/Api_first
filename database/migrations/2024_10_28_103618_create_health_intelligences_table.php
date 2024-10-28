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
        Schema::create('health_intelligences', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->unique();
            $table->string('boold_group'); //health
            $table->tinyInteger('Heart_disease')->default(0)->comment('0=no , 1=yes'); //health
            $table->tinyInteger('Blood_pressure')->default(0)->comment('0=no , 1=yes'); //health
            $table->tinyInteger('suger')->default(0)->comment('0=no , 1=yes'); //health
            $table->double('cm'); //health
            $table->double('weight'); //health
            $table->tinyInteger('bones_joints')->default(0)->comment('0=no , 1=yes'); //health
            $table->tinyInteger('Kidney_disease')->default(0)->comment('0=no , 1=yes'); //health
            $table->tinyInteger('Liver_disease')->default(0)->comment('0=no , 1=yes'); //health
            $table->tinyInteger('Mental_illness')->default(0)->comment('0=no , 1=yes'); //health
            $table->json('Note1')->nullable(); //health
            $table->tinyInteger('medicine')->default(0)->comment('0=no , 1=yes'); //health
            $table->tinyInteger('Food')->default(0)->comment('0=no , 1=yes'); //health
            $table->tinyInteger('etc')->default(0)->comment('0=no , 1=yes'); //health
            $table->json('detail')->nullable(); //health
            $table->json('medicine_list')->nullable(); //health
            $table->tinyInteger('surgery_injury')->default(0)->comment('0=no , 1=yes'); //health
            $table->tinyInteger('physical_ability')->default(1)->comment('0=no , 1=yes'); //health
            $table->json('physical_ability_detail')->nullable(); //health
            $table->tinyInteger('glasses')->default(0)->comment('0=no , 1=yes'); //health
            $table->tinyInteger('hear')->default(0)->comment('0=no , 1=yes'); //health
            $table->string('document_health'); //health


            $table->json('supported_by')->nullable(); //intelligent
            $table->json('Former_member')->nullable(); //intelligent
            $table->integer('party_id')->default(0); //intelligent
            $table->date('Date_connection')->nullable(); //intelligent
            $table->tinyInteger('Travel')->default(0)->comment('0=no, 1=yes')->nullable(); //intelligent
            $table->json('Reason_travelling')->nullable()->nullable(); //intelligent
            $table->tinyInteger('another_passport')->default(0)->comment('0=no, 1=yes')->nullable(); //intelligent
            $table->json('country_passport')->nullable()->nullable(); //intelligent
            $table->string('attach')->nullable(); //intelligent
            $table->json('family')->nullable(); //intelligent


            $table->foreignId('user_id')->constrained()->onDelete('cascade')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_intelligences');
    }
};
