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
        Schema::create('ticket_has_dn_user', function (Blueprint $table) {
            $table->uuid('ticket_id');
            $table->uuid('dn_user_id');
            $table->uuid('dn_role_id');
            $table->timestamps();

            $table->primary(['ticket_id', 'dn_user_id', 'dn_role_id']);
            $table->foreign('ticket_id')->references('ticket_id')->on('tickets')->onDelete('cascade');
            $table->foreign('dn_user_id')->references('dn_user_id')->on('dn_users')->onDelete('cascade');
            $table->foreign('dn_role_id')->references('dn_role_id')->on('dn_roles')->onDelete('cascade');
      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_has_dn_user');
    }
};
