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
        Schema::create('users', function (Blueprint $table) {
            $table->comment('table dùng để lưu trữ nhân sự');
            $table->id();
            $table->string('name')->comment('Tên nhân sự');
            $table->string('email')->unique()->comment('Email nhân sự ( dùng để đăng nhập)');
            $table->string('password')->comment('Password nhân sự');
            $table->timestamp('birth')->comment('Ngày sinh nhân sự');
            $table->text('avatar')->nullable()->comment('Avatar của nhân sự');
            $table->smallInteger('gender')->default(1)->comment('Giới tính: 1 - Nam | 2 - nữ');
            $table->string('phone')->nullable()->comment('SĐT Nhân viên');
            $table->text('address')->nullable()->comment('Địa chỉ nơi ở nhân viên');
            $table->smallInteger('permission')->comment('Phân quyền trong Admin: 16 - Admin | 12 - Bác sĩ | 99 - CSKH');
            $table->text('description')->nullable()->comment('Mô tả về nhân viên');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->bigInteger('updated_by')->nullable()->comment('Người cập nhật thông tin');
            $table->bigInteger('created_by')->nullable()->comment('Người tạo thông tin');
            $table->foreign('clinic_id')->references('id')->on('clinic')->onDelete('cascade');
            $table->unsignedBigInteger('clinic_id')->nullable();
            $table->rememberToken();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
