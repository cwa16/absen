<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->datetime('date');
            $table->datetime('start_work');
            $table->string('start_work_info');
            $table->string('start_work_info_url');
            $table->datetime('end_work');
            $table->string('end_work_info');
            $table->string('end_work_info_url');
            $table->string('desc');
            $table->string('link');
            $table->string('checked');
            $table->string('checked_by');
            $table->string('approval');
            $table->string('approval_by');
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
        Schema::dropIfExists('absens');
    }
}
