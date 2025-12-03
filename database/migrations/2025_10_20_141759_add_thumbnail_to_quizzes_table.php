<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_thumbnail_to_quizzes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->string('thumbnail')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('thumbnail');
        });
    }
};
