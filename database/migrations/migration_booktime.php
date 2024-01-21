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
        Schema::create('booktime', function (Blueprint $table) {
            $table->comment('table dùng để lưu trữ các lịch khám');
            $table->id();
            $table->string('time')->comment('Khoảng thời gian khám bệnh');
            $table->smallInteger('type')->nullable()->comment('Loại thời gian khám bệnh');
            $table->smallInteger('active')->default(1)->comment('Đang hoạt động không: 1 - có| 0 - không');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->bigInteger('updated_by')->nullable()->comment('Người cập nhật thông tin');
            $table->bigInteger('created_by')->nullable()->comment('Người tạo thông tin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
