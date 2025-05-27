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
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    // php artisan migrate:refresh criado um refrexh para limpar dodos atributos do banco de dados par adicionar outros atributos
    //----- depios------
    // php artisan db:seed --class=AdminSeeder para addicionar novamento os dados do admin
    public function down(): void
    {
//        Schema::table('users', function (Blueprint $table) {
//            $table->string('password')->nullable(false)->change();
//        });
    }
};
