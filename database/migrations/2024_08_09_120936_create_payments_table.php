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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_application_id');
            $table->string('payment_receipt_no', 50);
            $table->decimal('amount', 10, 2);
            $table->date('dated');
            $table->string('payment_receipt', 255); // Path to uploaded receipt
            $table->timestamps();

            // Ensure the foreign key is correctly formed
            $table->foreign('student_application_id')
                  ->references('id')
                  ->on('student_applications')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
