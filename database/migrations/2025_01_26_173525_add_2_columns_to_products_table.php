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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('auction_starting_price', 15, 2)->nullable()->after('current_price');
            $table->integer('auction_duration')->comment('Auction duration in seconds')->nullable()->after('auction_starting_price');
            $table->timestamp('auction_start_time')->nullable()->after('auction_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('auction_starting_price');
            $table->dropColumn('auction_duration');
            $table->dropColumn('auction_start_time');
        });
    }
};
