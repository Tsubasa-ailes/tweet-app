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
        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ユーザーID
            $table->text('content'); // ツイート本文
            $table->string('image_path')->nullable(); // 添付画像（任意）
            $table->tinyInteger('is_deleted')->default(0); // 削除フラグ: 0=表示, 1=削除, 2=シャドウバン
            $table->integer('retweet_count')->default(0); // リツイート数
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweets');
    }
};
