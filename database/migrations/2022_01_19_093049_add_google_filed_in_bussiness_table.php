<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogleFiledInBussinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('businesses', function (Blueprint $table) {
            //
            $table->string('google_analytic')->nullable()->after('meta_description');
            $table->string('fbpixel_code')->nullable()->after('google_analytic');
            $table->text('customjs')->nullable()->after('fbpixel_code');
            $table->string('status')->default('active')->after('links');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table(
            'businesses', function (Blueprint $table){
            $table->dropColumn('google_analytic');
            $table->dropColumn('fbpixel_code');
            $table->dropColumn('customjs');
            $table->dropColumn('status');
        }
        );
    }
}
