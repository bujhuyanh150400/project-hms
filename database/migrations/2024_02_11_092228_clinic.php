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
        Schema::create('clinic', function (Blueprint $table) {
            $table->comment('table dùng để lưu trữ các cơ sở phòng khám');
            $table->id();
            $table->string('name')->comment('Tên phòng khám');
            $table->string('province', 10)->comment('Tỉnh thành của phòng khám');
            $table->string('district', 10)->comment('Quận huyện của phòng khám');
            $table->string('ward', 10)->comment('Phường xã của phòng khám');
            $table->string('address')->comment('Địa chỉ cụ thể cơ sở phòng khám');
            $table->string('logo')->nullable()->comment('Ảnh đại diện phòng khám phòng khám');
            $table->text('description')->nullable()->comment('Mô tả phòng khám');
            $table->smallInteger('active')->default(1)->comment('Phòng khám có đang hoạt động không: 1 - có| 2 - không');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic');
    }
};
