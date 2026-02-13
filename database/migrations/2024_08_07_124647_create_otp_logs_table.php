<?php
// database/migrations/xxxx_xx_xx_create_otp_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpLogsTable extends Migration
{
    public function up()
    {
        Schema::create('otp_logs', function (Blueprint $table) {
            $table->id();
            $table->string('mobile_number');
            $table->integer('otp');
            $table->enum('status', ['pending', 'verified', 'failed'])->default('pending');
            $table->timestamps(); // This will add `created_at` and `updated_at` columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('otp_logs');
    }
}
