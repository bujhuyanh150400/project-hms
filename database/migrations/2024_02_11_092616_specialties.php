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
        Schema::create('specialties', function (Blueprint $table) {
            $table->comment('table dùng để lưu trữ các chuyên khoa');
            $table->id();
            $table->string('name')->comment('Tên chuyên khoa');
            $table->string('logo')->nullable()->comment('Ảnh đại diện chuyên khoa');
            $table->text('description')->nullable()->comment('Mô tả về chuyên khoa');
            $table->float('price')->nullable()->comment('Phí khám');
            $table->float('booking_price')->nullable()->comment('Phí đặt lịch');
            $table->smallInteger('active')->default(1)->comment('chuyên khoa có đang hoạt động không: 1 - có| 0 - không');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialties');
    }
};
