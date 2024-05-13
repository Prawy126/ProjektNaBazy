<?php

use App\Models\nurse;
use App\Models\procedure;
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
        Schema::create('treatments_nurses', function (Blueprint $table) {
            $table->foreignIdFor(nurse::class)->constrained();
            $table->foreginIdFor(procedure::class)->constrained();
            $table->integer("tak");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments_nurses');
    }
};
