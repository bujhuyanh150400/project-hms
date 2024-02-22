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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->comment('Bảng dùng để đề cập đến thuốc');
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('file');
            $table->bigInteger('total');
            $table->unsignedBigInteger('type_material_id')->nullable();
            $table->foreign('type_material_id')->references('id')->on('type_material')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
