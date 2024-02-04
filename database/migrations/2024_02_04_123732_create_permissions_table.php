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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        DB::table('permissions')->insert([
            ['name' => 'create_group', 'description' => 'Csoport létrehozása'],
            ['name' => 'edit_group', 'description' => 'Csoport szerkesztése'],
            ['name' => 'delete_group', 'description' => 'Csoport törlése'],
            ['name' => 'manage_group_members', 'description' => 'Csoport tagjainak kezelése'],
            ['name' => 'join_leave_group', 'description' => 'Csoportokhoz csatlakozás / kilépés']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};