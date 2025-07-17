<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostCodeAndAddressAndBuildingToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table)
        {
            // 郵便番号、住所、建物名を追加
            $table->string('post_code')->nullable()->after('email');
            $table->string('address')->nullable()->after('post_code');
            $table->string('building')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table)
        {
            //
            $table->dropColumn(['post_code', 'address', 'building']);
        });
    }
}
