<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEndpointTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endpoint_targets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('endpoint_id');
            $table->string('title')->default('');
            $table->string('uri')->default('');
            $table->string('method')->default('');
            $table->json('headers')->nullable();
            $table->text('body')->nullable();
            $table->unsignedTinyInteger('enabled')->default('1')->comment('1=是 2=否');
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
        Schema::dropIfExists('endpoint_targets');
    }
}
