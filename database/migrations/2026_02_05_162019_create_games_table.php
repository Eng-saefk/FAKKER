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
    Schema::create('games', function (Blueprint $table) {
        $table->id();
        $table->string('team_a'); // الفريق المستضيف
        $table->string('team_b'); // الفريق الضيف
        $table->dateTime('game_time'); // وقت المباراة
        $table->string('status')->default('upcoming'); // الحالة: upcoming, live, finished
        $table->string('result')->nullable(); // النتيجة النهائية (مثلاً 2-1)
        $table->integer('points_win')->default(100); // النقاط اللي بيكسبها المتوقع الصحيح
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
