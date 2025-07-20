<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // id（自動で連番）
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // コメントしたユーザー
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // コメントされた商品
            $table->string('content',255); // コメント内容（最大255文字）
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
        Schema::dropIfExists('comments');
    }
}
