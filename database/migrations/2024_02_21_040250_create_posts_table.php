<?php

use App\Models\PublishLevelEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText("content")->nullable();
            $table->string('slug')->unique();
            $table->string('status')->default('publish');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->foreignId('revision_id')->nullable()->constrained('posts')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->integer('order')->default(0);
            $table->string('publish_level')->default(PublishLevelEnum::$MEMBERSHIP);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
