<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('acknowledgment_no', 12)->unique();
            $table->string('course_type', 100);
            $table->string('course_name', 255);
            $table->string('college_name', 255);
            $table->string('course_registration_no', 50);
            $table->string('name', 100);
            $table->string('father_name', 100);
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->enum('category', ['General', 'OBC', 'SC', 'ST']);
            $table->text('address');
            $table->string('state', 50);
            $table->string('country', 50);
            $table->string('mobile_no', 10);
            $table->string('alternate_mobile_no', 10)->nullable();
            $table->string('whatsapp_no', 10)->nullable();
            $table->string('email', 255);
            $table->string('aadhaar', 12);
            $table->enum('status', ['pending_payment', 'payment_done', 'documents_uploaded', 'submitted'])->default('pending_payment');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('student_registrations')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_applications');
    }
};
