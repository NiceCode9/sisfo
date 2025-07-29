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
        Schema::table('biaya_pendaftaran', function (Blueprint $table) {
            $table->boolean('dapat_diangsur')->default(false)->after('wajib_bayar');
            $table->integer('max_cicilan')->nullable()->after('dapat_diangsur'); // maksimal berapa kali cicilan
            $table->decimal('min_dp', 10, 2)->nullable()->after('max_cicilan'); // minimal down payment
            $table->integer('jangka_waktu_hari')->nullable()->after('min_dp'); // dalam hari
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biaya_pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['dapat_diangsur', 'max_cicilan', 'min_dp', 'jangka_waktu_hari']);
        });
    }
};
