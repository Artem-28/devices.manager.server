<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_devices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('account_id');
            $table->string('serial_number')->unique();
            $table->boolean('confirm')->default(false);
            $table->timestamp('last_contact')->nullable();
            $table->text('access_token')->nullable();
            $table->timestamps();

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_devices');
    }
}
