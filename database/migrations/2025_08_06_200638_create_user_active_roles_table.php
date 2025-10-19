<?php

use App\Models\UserActiveRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    protected UserActiveRole $userActiveRole;

    public function __construct()
    {
        $this->userActiveRole = new UserActiveRole();
    }

    public function up(): void
    {
        Schema::create($this->userActiveRole->getTable(), function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('role');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->userActiveRole->getTable());
    }
};
