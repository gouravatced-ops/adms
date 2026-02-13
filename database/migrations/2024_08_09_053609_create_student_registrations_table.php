<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('student_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('state', 50);
            $table->enum('type', ['New', 'Renew'])->default('New');
            $table->enum('category', ['General', 'OBC', 'SC', 'ST']);
            $table->date('result_date')->nullable()->comment('For New Case');
            $table->date('certificate_date')->nullable()->comment('For Renewal Case');
            $table->string('mobile_no', 10);
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_registrations');
    }
};
