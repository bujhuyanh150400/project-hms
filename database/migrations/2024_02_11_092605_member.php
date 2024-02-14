<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member', function (Blueprint $table) {
            $table->comment('table dùng để lưu trữ khách hàng đã đăng kí tài khoản');
            $table->id();
            $table->string('email')->unique()->nullable()->comment('Email khách hàng');
            $table->string('phone')->unique()->nullable()->comment('SDT khách hàng');
            $table->string('password')->comment('Password khách hàng');
            $table->unsignedBigInteger('customer_id')->nullable()->comment('ID khách hàng');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->rememberToken();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
