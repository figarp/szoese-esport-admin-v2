<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name')->unique();
            $table->tinyInteger('permission_level')->default(0);
            $table->text('description')->nullable();
        });

        DB::table('roles')->insert([
            ['name' => 'vendeg', 'display_name' => 'Vendég', 'permission_level' => 0, 'description' => 'Vendég fiók. Be tud jelentkezni az oldalra és jelentkezni tud különböző csoportokba. Nem tag'],
            ['name' => 'tag', 'display_name' => 'Tag', 'permission_level' => 1, 'description' => 'Tag fiók. Azon vendégek, akik felvételt nyertek egy csoportba.'],
            ['name' => 'edzo', 'display_name' => 'Edző', 'permission_level' => 1, 'description' => 'Edző fiók. Jogosultságok szempontjából felér a Tag ranggal.'],
            ['name' => 'csapatkapitany', 'display_name' => 'Csapatkapitány', 'permission_level' => 2, 'description' => 'Csapatkapitány fiók. Azon tagok, akik ki lettek nevezve a csapat vezetésére. Csoportvezetők és vezetőségi tagok módosíthatják.'],
            ['name' => 'csoportvezeto', 'display_name' => 'Csoportvezető', 'permission_level' => 3, 'description' => 'Csoportvezető fiók. Azon tagok, akik ki lettek nevezve a játékoscsoportok vezetésére. Csak vezetőségi tagok módosíthatják.'],
            ['name' => 'besegito', 'display_name' => 'Besegítő', 'permission_level' => 1, 'description' => 'Besegítő fiók. Azon vendégek vagy tagok, akik plusz feladatokat vállaltak el. Csak vezetőségi tagok módosíthatják.'],
            ['name' => 'vezetoseg', 'display_name' => 'Vezetőség', 'permission_level' => 10, 'description' => 'Vezetőségi fiók. Mindenhez joga van az oldalon.'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};