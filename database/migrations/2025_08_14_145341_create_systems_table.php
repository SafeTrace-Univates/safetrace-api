<?php

use App\Models\System;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private System $system;

    public function __construct()
    {
        $this->system = new System();
    }

    public function up(): void
    {
        Schema::create($this->system->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->system->getTable());
    }
};
