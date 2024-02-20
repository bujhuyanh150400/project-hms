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
        Schema::create('schedules', function (Blueprint $table) {
            $table->comment('table dùng để lưu thông tin lịch khám giữa bệnh nhân và bác sĩ');
            $table->id();
            $table->smallInteger('timeType')->nullable()->comment('Khung giờ khám bệnh');
            $table->text('description')->nullable()->comment('Lý do khám');
            $table->smallInteger('status')->comment('Trạng thái khám bệnh');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('animal_id')->nullable()->comment('ID của thú cưng đi khám');
            $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id')->nullable()->comment('ID của bệnh nhân');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
            $table->unsignedBigInteger('booking_id')->nullable()->comment('ID của lịch đăng kí khám');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable()->comment('ID của bác sĩ tạo');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
