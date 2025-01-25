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
        Schema::create('ticket_has_part', function (Blueprint $table) {
            $table->uuid('part_id');
            $table->uuid('ticket_id');
            $table->timestamps();

            $table->primary(['part_id', 'ticket_id']);
            $table->foreign('part_id')->references('part_id')->on('parts')->onDelete('cascade');
            $table->foreign('ticket_id')->references('ticket_id')->on('tickets')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_has_part');
    }
};
