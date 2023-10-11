<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveStringColumnFromProductDetails extends Migration
{
    public function up()
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropColumn('string');
            $table->dropColumn('image');
        });
    }

    public function down()
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->string('string');
            $table->string('image');
        });
    }
}
