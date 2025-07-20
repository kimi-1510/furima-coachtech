<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // id（自動で連番）
            $table->string('name'); // 商品名
            $table->string('image'); // 商品画像
            $table->integer('price'); // 価格
            $table->text('description'); // 商品説明
            $table->string('status'); // 商品の状態（'良好'，'目立った傷や汚れなし'，'やや傷や汚れあり'，'状態が悪い'）
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 出品者
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null'); // ブランド名
            $table->boolean('is_sold')->default(false); // 売り切れかどうか
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
