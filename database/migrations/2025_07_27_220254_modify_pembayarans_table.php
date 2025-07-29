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
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->foreignId('detail_angsuran_id')->nullable()->after('biaya_pendaftaran_id')
                ->constrained('detail_angsurans')->onDelete('set null');
            $table->string('jenis_pembayaran')->default('penuh')->after('metode_pembayaran');
            // penuh, dp_angsuran, cicilan_angsuran
            $table->text('keterangan_angsuran')->nullable()->after('catatan');
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropConstrainedForeignId('detail_angsuran_id');
            $table->dropColumn(['jenis_pembayaran', 'keterangan_angsuran']);
        });
    }
};
