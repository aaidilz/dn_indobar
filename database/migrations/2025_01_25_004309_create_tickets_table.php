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
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('ticket_id')->primary();
            $table->uuid('customer_id')->nullable();
            $table->uuid('service_location_id')->nullable();
            $table->uuid('location_id')->nullable();
            $table->string('ticket_number');
            $table->date('ticket_date');
            $table->string('ticket_type');
            $table->string('problem_description')->nullable();
            $table->string('resolution_description')->nullable();
            $table->timestamps();
            
            $table->foreign('location_id')->references('location_id')->on('locations')->onDelete('cascade');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->foreign('service_location_id')->references('service_location_id')->on('service_locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
