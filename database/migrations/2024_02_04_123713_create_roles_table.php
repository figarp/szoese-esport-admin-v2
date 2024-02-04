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
            $table->string('display_name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        DB::table('roles')->insert([
            ['name' => 'admin', 'display_name' => 'Admin', 'description' => 'Adminisztrátor. Mindenhez van jogosultsága.'],
            ['name' => 'vezetoseg', 'display_name' => 'Vezetőség', 'description' => 'Vezetőségi tag. Létre hozhat, kezelhet és törölhet csoportokat.'],
            ['name' => 'csoportvezeto', 'display_name' => 'Csoportvezető', 'description' => 'Olyan tag fiókok, amelyek meg lettek bízva a csoportok vezetésével. A csoportjelentkezéseket ők bírálják el.'],
            ['name' => 'tag', 'display_name' => 'Tag', 'description' => 'Olyan vendég fiókok, amik jelenleg tagjai legalább 1 csoportnak.'],
            ['name' => 'vendeg', 'display_name' => 'Vendég', 'description' => 'Az oldalra regisztrált fiókok, de nem tagjai egy csoportnak sem.'],
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