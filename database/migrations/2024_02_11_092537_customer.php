<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->comment('table dùng để lưu trữ khách hàng đã đăng kí sử dụng dịch vụ');
            $table->id();
            $table->string('name')->comment('Tên Khách hàng');
            $table->string('email')->unique()->nullable()->comment('Email khách hàng');
            $table->string('phone')->unique()->nullable()->comment('SĐT khách hàng');
            $table->timestamp('birth')->comment('Ngày sinh khách hàng');
            $table->smallInteger('gender')->default(1)->comment('Giới tính: 1 - Nam | 2 - Nữ');
            $table->string('province', 10)->comment('Tỉnh thành của khách hàng');
            $table->string('district', 10)->comment('Quận huyện của khách hàng');
            $table->string('ward', 10)->comment('Phường xã của khách hàng');
            $table->string('address')->comment('Địa chỉ cụ thể khách hàng');
            $table->text('description')->nullable()->comment('Mô tả về khách hàng');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
