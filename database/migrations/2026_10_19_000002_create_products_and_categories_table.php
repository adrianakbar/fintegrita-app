<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('line_of_business')->index(); // finance, tech, intelligence, academy, advisory, knowledge
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->index(); // application, template, ebook, business_tool, training, service_custom
            $table->string('headline')->nullable();
            $table->longText('description')->nullable();
            $table->json('features')->nullable();
            $table->string('target_audience')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('sale_price', 15, 2)->nullable();
            $table->boolean('is_digital_download')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->text('license_terms')->nullable();
            $table->string('status')->default('draft')->index(); // draft, active, in_development, archived
            $table->string('image_url')->nullable();
            $table->string('demo_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('product_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('version')->default('1.0.0');
            $table->string('file_path');
            $table->string('file_name');
            $table->bigInteger('file_size')->default(0);
            $table->string('checksum')->nullable();
            $table->integer('download_limit')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->unsignedBigInteger('order_id')->nullable()->index();
            $table->string('license_key')->unique();
            $table->string('license_type')->default('single'); // single, multi, enterprise, lifetime
            $table->timestamp('expires_at')->nullable();
            $table->string('status')->default('active')->index(); // active, revoked, expired
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('licenses');
        Schema::dropIfExists('product_files');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
