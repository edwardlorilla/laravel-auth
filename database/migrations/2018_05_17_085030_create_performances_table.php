<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *teaching performance
     * @return void
     */
    public function up()
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('semester')->default(1);
            $table->integer('school_year_start')->default((int)date("Y"));
            $table->integer('school_year_end')->default((int)date("Y"));
            $table->float('target', 8, 2)->default(0);
            $table->float('ceta', 8, 2)->default(0);
            $table->float('etd', 8, 2)->default(0);
            $table->float('etp', 8, 2)->default(0);
            $table->float('ets', 8, 2)->default(0);
            $table->float('etse', 8, 2)->default(0);
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
        Schema::dropIfExists('performances');
        $table->dropForeign('performances_user_id_foreign');
    }
}
