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
        Schema::create('submenus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_submenu')->unique();
            $table->integer('urutan');
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->string('link')->unique();
            $table->timestamps();

            $table->unique(['menu_id', 'urutan']);
            $table->unique(['menu_id', 'nama_submenu']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submenus');
    }
};
