<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->comment('table dùng để lưu trữ thú cưng của khách hàng');
            $table->id();
            $table->string('name')->comment('Tên thú cưng');
            $table->text('avatar')->nullable()->comment('Avatar của nhân sự');
            $table->smallInteger('age')->comment('Tuổi của thú cưng');
            $table->smallInteger('type')->comment('Loại thú cưng - có trong TypeAnimal');
            $table->string('species')->comment('Chủng loài thú cưng');
            $table->smallInteger('gender')->default(1)->comment('Giới tính: 1 - Đực | 2 - Cái');
            $table->text('description')->nullable()->comment('Ghi chú về thú cưng');
            $table->unsignedBigInteger('customer_id')->nullable()->comment('ID khách hàng');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
