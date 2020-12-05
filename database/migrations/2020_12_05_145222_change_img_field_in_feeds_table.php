<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeImgFieldInFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feeds', function (Blueprint $table) {
            try {
                DB::statement('ALTER TABLE feeds MODIFY img MEDIUMBLOB;');
            }catch (\Exception $exception){
                DB::statement('ALTER TABLE feeds ALTER img MEDIUMBLOB;');
            }


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feeds', function (Blueprint $table) {
            try {
                DB::statement('ALTER TABLE feeds MODIFY img MEDIUMBLOB;');
            }catch (\Exception $exception){
                DB::statement('ALTER TABLE feeds MODIFY img VARCHAR(255);');
            }

        });
    }
}
