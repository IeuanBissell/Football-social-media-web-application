<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('standings', function (Blueprint $table) {
            $table->id();

            $table->integer('games_played')->nullable();
            $table->integer('points')->nullable();
            $table->integer('wins')->nullable();
            $table->integer('losses')->nullable();
            $table->integer('draws')->nullable();
            $table->integer('goals_scored')->nullable();
            $table->integer('goals_conceded')->nullable();
            $table->integer('goal_difference')->nullable();
            
            $table->bigInteger('league_id')->unsigned();
            $table->bigInteger('team_id')->unsigned();

            $table->foreign('league_id')->references('id')->on('leagues')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('team_id')->references('id')->on('teams')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standings');
    }
};
