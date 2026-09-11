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
    Schema::create('recordings', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('camera_id');
        $table->string('region');
        $table->string('warehouse');
        $table->string('nvr_dvr');
        $table->string('channel');
        $table->string('file_path');
        $table->string('file_name');
        $table->timestamp('started_at')->nullable();
        $table->timestamp('ended_at')->nullable();
        $table->integer('duration')->nullable(); 
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recordings');
    }
};
