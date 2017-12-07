<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');

            $table->string('title');

            $table->string('slug')->unique();

            $table->string('cover_path')->nullable();

            $table->text('body');

            $table->decimal('price', 10, 2);

            $table->string('sample_path');

            $table->string('file_path');

            $table->unsignedInteger('user_id')->index();

            $table->unsignedInteger('category_id')->index();

            $table->tinyInteger('approval_status');
            $table->timestamp('approval_at')->nullable();

            $table->softDeletes();

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
        Schema::dropIfExists('products');
    }
}
