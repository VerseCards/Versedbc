<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('user_id')->nullable();
            $table->text('slug')->nullable();
            $table->text('title')->nullable();
            $table->string('designation')->nullable();
			$table->string('secret_code')->nullable();
            $table->text('sub_title')->nullable();
            $table->text('description')->nullable();
            $table->text('banner')->nullable();
            $table->text('logo')->nullable();
            $table->text('card_theme')->nullable();
            $table->string('theme_color')->nullable();
            $table->text('links')->nullable();
			$table->bigInteger('scans_taps')->default(0)->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_image')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('businesses');
    }
}
