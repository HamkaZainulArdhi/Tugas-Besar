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
        Schema::create('hasil_penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurnal_id')->constrained('jurnals')->onDelete('cascade');
            $table->foreignId('kategori_penilaian_id')->constrained('kategori_penilaians')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users');
            $table->boolean('is_accepted'); // true = Ceklist, false = Tolak
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_penilaians');
    }
};
