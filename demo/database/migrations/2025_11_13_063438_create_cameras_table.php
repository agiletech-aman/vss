<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cameras', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('nvr_id');
            $table->foreign('nvr_id')->references('id')->on('n_v_r_s')->onDelete('cascade');

            $table->integer('channel'); 

            $table->string('rtsp')->nullable();
            $table->string('site_url')->nullable();
            $table->string('remote_path')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cameras');
    }
};
