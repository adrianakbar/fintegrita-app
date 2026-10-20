<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use App\Support\FilamentKit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Proyek & Layanan';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Proyek';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Proyek')->schema([
                    FilamentKit::relation('customer_id', 'Customer', 'name', 'Pelanggan'),
                    Forms\Components\TextInput::make('project_code')
                        ->label('Kode Proyek')
                        ->default('PRJ-'.now()->format('Y').'-'.Str::upper(Str::random(3)))
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('name')->label('Nama Proyek')->required(),
                    Forms\Components\Select::make('type')
                        ->label('Jenis')
                        ->options([
                            'website_portal' => 'Website Portal',
                            'finance_app' => 'Aplikasi Keuangan',
                            'koperasi_system' => 'Sistem Koperasi',
                            'education_system' => 'Sistem Pendidikan',
                            'pos_retail' => 'POS Retail',
                            'api_integration' => 'Integrasi API',
                        ])
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'proposal' => 'Proposal',
                            'contract_signed' => 'Kontrak Ditandatangani',
                            'in_progress' => 'Dikerjakan',
                            'uat_testing' => 'UAT Testing',
                            'completed' => 'Selesai',
                            'maintenance' => 'Maintenance',
                        ])
                        ->default('proposal')
                        ->required(),
                    Forms\Components\Select::make('pm_id')
                        ->label('Project Manager')
                        ->relationship('projectManager', 'name')
                        ->searchable()
                        ->preload(),
                    Forms\Components\Textarea::make('scope_summary')
                        ->label('Ringkasan Scope')
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Section::make('Nilai Kontrak & Jadwal')->schema([
                    FilamentKit::money('budget', 'Budget'),
                    FilamentKit::money('contract_value', 'Nilai Kontrak'),
                    Forms\Components\DatePicker::make('start_date')->label('Mulai'),
                    Forms\Components\DatePicker::make('target_date')->label('Target Selesai'),
                    Forms\Components\DatePicker::make('actual_completion_date')->label('Selesai Aktual'),
                ])->columns(2),

                Forms\Components\Section::make('Tautan')->schema([
                    Forms\Components\TextInput::make('repo_url')->label('Repo URL')->url(),
                    Forms\Components\TextInput::make('staging_url')->label('Staging URL')->url(),
                    Forms\Components\TextInput::make('production_url')->label('Production URL')->url(),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project_code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Proyek')
                    ->searchable()
                    ->description(fn ($record) => $record->customer?->name),
                Tables\Columns\TextColumn::make('type')->label('Jenis')->badge()->toggleable(),
                FilamentKit::moneyColumn('contract_value', 'Nilai Kontrak')->toggleable(),
                Tables\Columns\TextColumn::make('target_date')
                    ->label('Target')
                    ->date('d M Y')
                    ->color(fn ($record) => $record->target_date?->isPast() && ! in_array($record->status, ['completed', 'maintenance'])
                        ? 'danger' : 'gray')
                    ->sortable(),
                FilamentKit::statusColumn(),
                Tables\Columns\TextColumn::make('projectManager.name')->label('PM')->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'proposal' => 'Proposal',
                        'contract_signed' => 'Kontrak Ditandatangani',
                        'in_progress' => 'Dikerjakan',
                        'uat_testing' => 'UAT Testing',
                        'completed' => 'Selesai',
                        'maintenance' => 'Maintenance',
                    ]),
                Tables\Filters\SelectFilter::make('customer')
                    ->label('Pelanggan')
                    ->relationship('customer', 'name')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
