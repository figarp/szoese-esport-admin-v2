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
            $table->text('description')->nullable();
        });

        DB::table('roles')->insert([
            ['name' => 'vendeg', 'display_name' => 'Vendég', 'description' => 'Vendég fiók. Be tud jelentkezni az oldalra és jelentkezni tud különböző csoportokba. Nem tag'],
            ['name' => 'tag', 'display_name' => 'Tag', 'description' => 'Tag fiók. Azon vendégek, akik felvételt nyertek egy csoportba.'],
            ['name' => 'csapatkapitany', 'display_name' => 'Csapatkapitány', 'description' => 'Csapatkapitány fiók. Azon tagok, akik ki lettek nevezve a csapat vezetésére. Csoportvezetők és vezetőségi tagok módosíthatják.'],
            ['name' => 'csoportvezeto', 'display_name' => 'Csoportvezető', 'description' => 'Csoportvezető fiók. Azon tagok, akik ki lettek nevezve a játékoscsoportok vezetésére. Csak vezetőségi tagok módosíthatják.'],
            ['name' => 'besegito', 'display_name' => 'Besegítő', 'description' => 'Besegítő fiók. Azon vendégek vagy tagok, akik plusz feladatokat vállaltak el. Csak vezetőségi tagok módosíthatják.'],
            ['name' => 'vezetoseg', 'display_name' => 'Vezetőség', 'description' => 'Vezetőségi fiók. Mindenhez joga van az oldalon.'],
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