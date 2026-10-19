<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('project_code')->unique(); // PRJ-YYYY-XXX
            $table->string('name');
            $table->string('type')->index(); // website_portal, finance_app, koperasi_system, education_system, pos_retail, api_integration
            $table->text('scope_summary')->nullable();
            $table->decimal('budget', 15, 2)->default(0);
            $table->decimal('contract_value', 15, 2)->default(0);
            $table->date('start_date')->nullable();
            $table->date('target_date')->nullable();
            $table->date('actual_completion_date')->nullable();
            $table->string('status')->default('proposal')->index(); // proposal, contract_signed, in_progress, uat_testing, completed, maintenance
            $table->foreignId('pm_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('repo_url')->nullable();
            $table->string('staging_url')->nullable();
            $table->string('production_url')->nullable();
            $table->timestamps();
        });

        Schema::create('project_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('payment_percentage')->default(0);
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('status')->default('pending')->index(); // pending, in_progress, review, approved
            $table->timestamps();
        });

        Schema::create('project_deliverables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_milestone_id')->constrained('project_milestones')->cascadeOnDelete();
            $table->string('title');
            $table->string('file_path')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('submitted')->index(); // submitted, accepted, revision_needed
            $table->timestamps();
        });

        Schema::create('project_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('cost_category')->index(); // hosting_infra, third_party_api, subcontractor, hardware, operational
            $table->decimal('amount', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('receipt_path')->nullable();
            $table->date('incurred_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_costs');
        Schema::dropIfExists('project_deliverables');
        Schema::dropIfExists('project_milestones');
        Schema::dropIfExists('projects');
    }
};
