<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('customer_number')->unique(); // CUST-YYYYMMDD-XXXX
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('email')->index();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('category')->default('individual'); // individual, umkm, koperasi, education, corporate
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('tax_number')->nullable(); // NPWP
            $table->text('notes')->nullable();
            $table->string('status')->default('active')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
