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

            $table->string('slug');

            $table->text('body');

            $table->decimal('price', 10, 2);

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
