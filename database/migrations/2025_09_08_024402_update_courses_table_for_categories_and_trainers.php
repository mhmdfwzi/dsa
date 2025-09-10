<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::table('courses', function (Blueprint $table) { 
        $table->integer('duration')->nullable();
        $table->enum('level', ['beginner', 'intermediate', 'advanced'])->nullable();
        $table->boolean('requires_approval')->default(true);
    });
}

public function down()
{
    Schema::table('courses', function (Blueprint $table) {
        $table->dropForeign(['category_id']);
        $table->dropForeign(['trainer_id']);
        $table->dropColumn(['category_id', 'trainer_id', 'instructor_name', 'duration', 'level', 'requires_approval']);
    });
}
};
