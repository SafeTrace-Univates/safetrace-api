<?php

use App\Models\Alert;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private string $tableName;
    private Alert $model;

    public function __construct()
    {
        $this->model     = new Alert();
        $this->tableName = $this->model->getTable();
    }

    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->foreignId('ref_user')->constrained('users', 'id');
            $table->text('name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
