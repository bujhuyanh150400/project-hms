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
        Schema::create('bookings', function (Blueprint $table) {
            $table->comment('table dùng để lưu thông tin đăng kí lịch khám của bác sĩ');
            $table->id();
            $table->string('timeType')->comment('Khung giờ đặt lịch');
            $table->string('timeTypeSelected')->nullable()->comment('Khung giờ khám bệnh đã được chọn');
            $table->timestamp('date')->comment('Ngày khám');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->comment('ID của bác sĩ tạo');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
