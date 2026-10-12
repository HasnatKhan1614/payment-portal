<?php

// Historical filename: adds payment_confirmed_at only (confirm-code column removed).

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('payments', 'payment_confirmed_at')) {
            return;
        }

        Schema::table('payments', function (Blueprint $table) {
            $table->timestamp('payment_confirmed_at')->nullable()->after('invoice_number');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('payments', 'payment_confirmed_at')) {
            return;
        }

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_confirmed_at');
        });
    }
};
