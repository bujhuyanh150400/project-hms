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
            $table->string('address')->comment('Địa chỉ phòng khám');
            $table->string('image')->comment('Ảnh phòng khám phòng khám');
            $table->text('description')->comment('Mô tả phòng khám');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->bigInteger('updated_by')->nullable()->comment('Người cập nhật thông tin');
            $table->bigInteger('created_by')->nullable()->comment('Người tạo thông tin');
            $table->rememberToken();
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
