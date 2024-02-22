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
        Schema::create('line_webhook_events', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('mode');
            $table->bigInteger('timestamp');
            $table->json('source')->nullable();
            $table->string('webhook_event_id');
            $table->boolean('delivery_content_is_redelivery')->nullable();
            $table->string('reply_token')->nullable();
            $table->json('message')->nullable();
            $table->json('postback')->nullable();
            $table->string('text', 1000)->nullable();
            $table->json('mention')->nullable();
            $table->string('quoted_message_id')->nullable();
            $table->json('content_provider')->nullable();
            $table->json('image_set')->nullable();
            $table->string('file_name')->nullable();
            $table->integer('file_size')->nullable();
            $table->string('title')->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('package_id')->nullable();
            $table->string('sticker_id')->nullable();
            $table->json('unsend')->nullable();
            $table->json('joined')->nullable();
            $table->json('left')->nullable();
            $table->json('video_play_complete')->nullable();
            $table->json('beacon')->nullable();
            $table->json('link')->nullable();
            $table->json('things')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_webhook_events');
    }
};
