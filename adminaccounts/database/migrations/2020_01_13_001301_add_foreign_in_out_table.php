<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignInOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('in_out', function (Blueprint $table) {
//            $table->foreign('account_id')
//                ->references('id')
//                ->on('account')
//                ->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('in_out', function (Blueprint $table) {
//            $table->dropForeign('int_out_account_id_foreign');
//        });
    }
}
