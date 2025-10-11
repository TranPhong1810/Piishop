<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveImageColumnFromProductDetails extends Migration
{
    public function up()
    {
        Schema::table('product_details', function (Blueprint $table) {
            if (Schema::hasColumn('product_details', 'image')) {
                $table->dropColumn('image');
            }
        });
    }

    public function down()
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->string('image');
        });
    }
}
