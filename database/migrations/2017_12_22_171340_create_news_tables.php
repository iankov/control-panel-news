<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->default(0);
            $table->string('title')->default('');
            $table->string('keywords')->default('');
            $table->string('description')->default('');
            $table->string('slug')->default('')->unique();
            $table->boolean('active')->unsigned()->default(1);
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->default(0);
            $table->string('title')->default('')->index();
            $table->string('slug')->default('')->unique();
            $table->longText('content')->default('');
            $table->string('keywords')->default('');
            $table->string('description')->default('');
            $table->string('import_id')->default('')->index();
            $table->string('image')->default('');
            $table->string('source')->default('');
            $table->boolean('active')->unsigned()->default(1);
            $table->integer('views')->unsigned()->default(0);
            $table->timestamps();

            $table->index(['category_id', 'created_at']);
            $table->index('created_at');
            $table->index('updated_at');
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
        Schema::dropIfExists('news_categories');
    }
}
