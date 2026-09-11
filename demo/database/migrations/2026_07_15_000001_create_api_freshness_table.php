<?php
// database/migrations/2026_07_15_000001_create_api_freshness_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('api_data_freshness', function (Blueprint $table) {
            $table->id();
            $table->string('api_source');          // nms, frs, sack, iot_cam, iot_gas
            $table->unsignedInteger('warehouse_id')->nullable();
            $table->string('warehouse_name');
            $table->string('region_name')->nullable();
            $table->timestamp('last_received_at')->nullable(); // last data timestamp from API
            $table->timestamp('last_checked_at');              // when we ran the check
            $table->enum('status', ['fresh','stale','missing'])->default('missing');
            $table->integer('record_count')->default(0);       // how many records found
            $table->timestamps();

            $table->index(['api_source','warehouse_id']);
            $table->index(['api_source','status']);
            $table->index('last_received_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_data_freshness');
    }
};
