<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsdEquivalentToCryptoDepositsTable extends Migration
{
    public function up()
    {
        Schema::table('crypto_deposits', function (Blueprint $table) {
            $table->decimal('usd_equivalent', 24, 8)->nullable();
        });
    }

    public function down()
    {
        Schema::table('crypto_deposits', function (Blueprint $table) {
            $table->dropColumn('usd_equivalent');
        });
    }
}
