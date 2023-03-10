<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('category', 20)->default('news')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('title', 255)->index();
            $table->text('isi');
            $table->string('images', 255)->nullable()->index();
            $table->string('videos', 255)->nullable()->index();
            $table->string('files', 255)->nullable()->index();
            $table->string('highlight_image')->nullable();
            $table->integer('highlight_status')->default(1)->index();
            $table->datetime('tgl_terbit')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
