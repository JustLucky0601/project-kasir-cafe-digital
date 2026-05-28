<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('produks', function (Blueprint $table) {
            if (!Schema::hasColumn('produks', 'best_seller')) {
                $table->boolean('best_seller')->default(false)->after('tersedia');
            }
        });
    }

    public function down(): void {
        Schema::table('produks', function (Blueprint $table) {
            if (Schema::hasColumn('produks', 'best_seller')) {
                $table->dropColumn('best_seller');
            }
        });
    }
};
