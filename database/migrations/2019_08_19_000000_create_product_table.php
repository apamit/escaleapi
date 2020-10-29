<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('business_id');
                $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
                $table->string('name');
                $table->string('description')->nullable($value = true);
                $table->float('mrp')->default(0);
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
        if (Schema::hasTable('products')) {
            if (Schema::hasColumn('products', 'business_id')) {
                Schema::table('products', function (Blueprint $table) {
                    $table->dropForeign('products_business_id_foreign');
                    $table->dropIndex('products_business_id_foreign');
                });
            }
            Schema::dropIfExists('products');
        }
    }
}
