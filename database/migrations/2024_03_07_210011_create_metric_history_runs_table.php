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
        Schema::create('metric_history_runs', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->decimal('accessibility_metric', 8, 2)->nullable();;
            $table->decimal('pwa_metric', 8, 2)->nullable();;
            $table->decimal('performance_metric', 8, 2)->nullable();;
            $table->decimal('seo_metric', 8, 2)->nullable();;
            $table->decimal('best_practices_metric', 8, 2)->nullable();;
            $table->unsignedBigInteger('strategy_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metric_history_runs');
    }
};
