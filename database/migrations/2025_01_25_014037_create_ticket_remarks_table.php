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
        Schema::create('ticket_remarks', function (Blueprint $table) {
            $table->uuid('remark_id')->primary();
            $table->uuid('ticket_id');
            $table->date('remark_date');
            $table->string('remark_status');
            $table->string('remark_description');
            $table->timestamps();

            $table->foreign('ticket_id')->references('ticket_id')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_remarks');
    }
};
