<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('member', function (Blueprint $table) {
            $table->comment('table dùng để lưu trữ khách hàng đã đăng kí tài khoản');
            $table->id();
            $table->string('name')->comment('Tên khách hàng');
            $table->string('email')->unique()->comment('Email khách hàng');
            $table->timestamp('birth')->comment('Ngày sinh khách hàng');
            $table->text('avatar')->nullable()->comment('Avatar của khách hàng');
            $table->smallInteger('gender')->default(1)->comment('Giới tính: 1 - Nam | 2 - nữ');
            $table->string('phone')->nullable()->comment('SĐT khách hàng');
            $table->text('address')->nullable()->comment('Địa chỉ nơi ở của khách hàng');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
