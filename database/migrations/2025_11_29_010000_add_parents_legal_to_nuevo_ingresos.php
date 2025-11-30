<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nuevo_ingresos', function (Blueprint $table) {
            // Progenitores (representantes existentes)
            $table->unsignedBigInteger('representante_padre_id')->nullable()->after('representante_id');
            $table->unsignedBigInteger('representante_madre_id')->nullable()->after('representante_padre_id');
            // Representante legal
            $table->unsignedBigInteger('representante_legal_id')->nullable()->after('representante_madre_id');

            $table->foreign('representante_padre_id')->references('id')->on('representantes')->onDelete('set null');
            $table->foreign('representante_madre_id')->references('id')->on('representantes')->onDelete('set null');
            $table->foreign('representante_legal_id')->references('id')->on('representante_legal')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('nuevo_ingresos', function (Blueprint $table) {
            $table->dropForeign(['representante_padre_id']);
            $table->dropForeign(['representante_madre_id']);
            $table->dropForeign(['representante_legal_id']);
            $table->dropColumn(['representante_padre_id', 'representante_madre_id', 'representante_legal_id']);
        });
    }
};
