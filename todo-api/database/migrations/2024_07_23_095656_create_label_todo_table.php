<?php

use App\Models\Label;
use App\Models\Todo;
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
        Schema::create('label_todo', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Label::class);
            $table->foreignIdFor(Todo::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('label_todo');
    }
};