<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->index(); // financial_literacy, umkm_accounting, management_training, kids_coding, bimtek_institutional
            $table->string('format')->default('online'); // online, offline, hybrid
            $table->string('level')->default('beginner'); // beginner, intermediate, advanced
            $table->string('headline')->nullable();
            $table->json('syllabus')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('sale_price', 15, 2)->nullable();
            $table->integer('max_participants')->default(30);
            $table->string('status')->default('draft')->index(); // draft, scheduled, ongoing, completed
            $table->string('banner_url')->nullable();
            $table->timestamps();
        });

        Schema::create('course_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->integer('session_number')->default(1);
            $table->string('title');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('location_or_link')->nullable();
            $table->string('recording_url')->nullable();
            $table->string('instructor_name')->nullable();
            $table->timestamps();
        });

        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->unsignedBigInteger('order_id')->nullable()->index();
            $table->string('enrollment_number')->unique();
            $table->string('status')->default('registered')->index(); // registered, active, completed, dropped
            $table->integer('progress_percentage')->default(0);
            $table->timestamp('certificate_issued_at')->nullable();
            $table->string('certificate_number')->nullable()->unique();
            $table->string('certificate_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_enrollments');
        Schema::dropIfExists('course_sessions');
        Schema::dropIfExists('courses');
    }
};
