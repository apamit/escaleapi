<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('business')) {
            Schema::create('business', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->string('company_name');
                $table->string('email')->unique();
                $table->string('registration_no')->unique();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable($value = true)->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('business')) {
            if (Schema::hasColumn('business', 'user_id')) {
                Schema::table('business', function (Blueprint $table) {
                    $table->dropForeign('business_user_id_foreign');
                    $table->dropIndex('business_user_id_foreign');
                });
            }
            Schema::dropIfExists('business');
        }
    }
}
