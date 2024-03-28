<?php

use App\Models\Type;
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
        Schema::table('projects', function (Blueprint $table) {
            // Definiamo la colonna
            // $table->unsignedBigInteger('type_id')->nullable()->after('id');

            // Definiamo la chiave esterna
            // $table->foreign('type_id')->references('id')->on('types')->nullOnDelete();

            // Soluzione in una riga, funziona solo se si seguono le convenzioni
            // $table->foreignId('type_id')->after('id')->nullable()->constrained()->nullOnDelete();

            // Alternativa ancora più semplice, funziona solo se si seguono le convenzioni
            $table->foreignIdFor(Type::class)->after('id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Rimuoviamo la relazione
            // $table->dropForeign('projects_type_id_foreign');

            // Soluzione in una riga, funziona solo se si seguono le convenzioni
            $table->dropForeignIdFor(Type::class);

            // Rimuoviamo la colonna
            $table->dropColumn('type_id');
        });
    }
};
