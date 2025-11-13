<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('alert_contact', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ref_alert')->constrained('alert', 'id');
            $table->foreignId('ref_contact')->constrained('contact', 'id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alert_contact');
    }
};
