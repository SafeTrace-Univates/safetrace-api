<?php

use App\Models\Recording;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    private string $tableName;
    private Recording $model;

    public function __construct()
    {
        $this->model     = new Recording();
        $this->tableName = $this->model->getTable();
    }

    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->foreignId('ref_alert')->constrained('alert', 'id');
            $table->text('file_path');
            $table->integer('duration');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
