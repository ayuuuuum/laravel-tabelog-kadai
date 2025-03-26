<?php

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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            //unsigned()⇒マイナス禁止
            $table->integer('price')->unsigned();
            //開店時間
            $table->time('open_time');
            //閉店時間
            $table->time('close_time');
            //Eloquentは外部キーカラムを自動的に決定する(親モデルの小文字クラス名に「_id」という接尾辞)
            //$table->foreignID('category_id')->constrained()->onDelete('cascade');
            $table->integer('category_id')->unsigned();
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
        Schema::dropIfExists('shops');
    }
};
