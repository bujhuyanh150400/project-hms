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
        Schema::create('histories', function (Blueprint $table) {
            $table->comment('table dùng để lưu lại lịch sử khám bệnh giữa bệnh nhân và bác sĩ');
            $table->id();
            $table->string('file')->nullable()->comment('Ảnh hoặc file liên quan đến việc khám bệnh');
            $table->text('description_animal')->nullable()->comment('mô tả về tình trạng của bệnh của thú cưng');
            $table->text('prescription')->nullable()->comment('Đơn thuốc');
            $table->bigInteger('price')->nullable()->comment('Giá tiền lần khám này');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('schedule_id')->nullable()->comment('ID của lịch sử khám bệnh');
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->unsignedBigInteger('animal_id')->nullable()->comment('ID của thú cưng');
            $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
