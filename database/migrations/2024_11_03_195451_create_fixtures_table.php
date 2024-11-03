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
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('league_id')->unsigned();
            $table->bigInteger('home_team_id')->unsigned();
            $table->bigInteger('away_team_id')->unsigned();

            $table->dateTime('match_date');
            $table->string('location');

            $table->integer('home_team_score')->nullable();
            $table->integer('away_team_score')->nullable();

            $table->foreign('league_id')->references('id')->on('leagues')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('home_team_id')->references('id')->on('teams')
                ->onDelete('cascade')->onUpdate('cascade');
            
            $table->foreign('away_team_id')->references('id')->on('teams')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
