<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotos_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loto_id');
            $table->foreign("loto_id")->references("id")->on("lotos");
            $table->string('name');
            $table->integer('contest_number');
            $table->string('contest_date')->nullable();
            $table->string('place')->nullable();
            $table->longText('dozens');
            $table->longText('awards')->nullable();
            $table->longText('awarded_states')->nullable();
            $table->boolean('accumulated')->default(0);
            $table->string('accumulated_next_contest')->nullable();
            $table->string('date_next_contest')->nullable();
            $table->string('next_context_number')->nullable();
            $table->longText('heart_team')->nullable();
            $table->string('lucky_month')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lotos_results');
    }
};
