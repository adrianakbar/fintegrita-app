<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Chart of Accounts (COA)
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g. 1-1001, 4-1001
            $table->string('name');
            $table->string('type')->index(); // asset, liability, equity, revenue, expense
            $table->string('normal_balance')->default('debit'); // debit, credit
            $table->foreignId('parent_id')->nullable()->constrained('accounts')->nullOnDelete();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Fiscal Periods
        Schema::create('fiscal_periods', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('period_number'); // 1 - 12 (month)
            $table->string('name'); // e.g. Oktober 2026
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_closed')->default(false);
            $table->timestamp('closed_at')->nullable();
            $table->foreignId('closed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique(['year', 'period_number']);
        });

        // 3. Cash & Bank Accounts
        Schema::create('cash_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('accounts')->cascadeOnDelete();
            $table->string('name'); // e.g. Rekening BCA Operasional, Kas Kecil
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_holder')->nullable();
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Double-entry Journal Entries
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->string('entry_number')->unique(); // JRN-YYYYMMDD-XXXX
            $table->date('entry_date')->index();
            $table->string('reference_type')->nullable()->index(); // Order, Invoice, Payment, Expense, Payroll, Manual
            $table->unsignedBigInteger('reference_id')->nullable()->index();
            $table->string('reference_number')->nullable();
            $table->text('description');
            $table->decimal('total_debit', 15, 2)->default(0);
            $table->decimal('total_credit', 15, 2)->default(0);
            $table->boolean('is_posted')->default(false)->index();
            $table->timestamp('posted_at')->nullable();
            $table->boolean('is_reversed')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 5. Journal Lines
        Schema::create('journal_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_entry_id')->constrained('journal_entries')->cascadeOnDelete();
            $table->foreignId('account_id')->constrained('accounts')->cascadeOnDelete();
            $table->string('description')->nullable();
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->integer('line_order')->default(0);
            $table->timestamps();
        });

        // 6. Expenses & Operational Outflow
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('expense_number')->unique(); // EXP-YYYYMMDD-XXXX
            $table->foreignId('cash_account_id')->nullable()->constrained('cash_accounts')->nullOnDelete();
            $table->foreignId('account_id')->nullable()->constrained('accounts')->nullOnDelete(); // Expense category COA
            $table->string('category')->index(); // operational, salary, software_license, server_infra, marketing, tax, other
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('payee');
            $table->text('description');
            $table->string('receipt_path')->nullable();
            $table->string('status')->default('draft')->index(); // draft, pending_approval, approved, rejected, paid
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        // 7. Multi-level Approvals
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->string('approvable_type')->index();
            $table->unsignedBigInteger('approvable_id')->index();
            $table->integer('step')->default(1);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('action')->index(); // approved, rejected, revised
            $table->text('comments')->nullable();
            $table->timestamp('action_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approvals');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('journal_lines');
        Schema::dropIfExists('journal_entries');
        Schema::dropIfExists('cash_accounts');
        Schema::dropIfExists('fiscal_periods');
        Schema::dropIfExists('accounts');
    }
};
