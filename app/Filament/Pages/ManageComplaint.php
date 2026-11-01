<?php

namespace App\Filament\Pages;

use App\Rules\SafeUrl;
use App\Support\Settings;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageComplaint extends Page
{
    protected string $view = 'filament.pages.manage-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Link;

    protected static string|UnitEnum|null $navigationGroup = 'Navigasi & Sistem';

    protected static ?string $navigationLabel = 'Modul Pengaduan';

    protected static ?string $title = 'Modul Pengaduan (Link Tombol Navbar)';

    protected static ?int $navigationSort = 2;

    public ?array $data = [];

    public static function canAccess(): bool
    {
        $user = auth()->user();

        return $user && $user->hasAnyRole(['superadmin', 'koordinator']);
    }

    public function mount(): void
    {
        $this->form->fill([
            'report_cta_label' => Settings::get('report.cta_label', 'Pengaduan'),
            'report_cta_type' => Settings::get('report.cta_type', 'url'),
            'report_cta_value' => Settings::get('report.cta_value', 'saluran-pelaporan'),
            'report_cta_new_tab' => (bool) Settings::get('report.cta_new_tab', true),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Konfigurasi Link Tombol "Pengaduan" di Navbar')
                    ->description('Isikan link website tujuan untuk tombol Pengaduan di navbar atas dan beranda. Ketika tombol diklik oleh pengunjung di halaman publik, browser akan langsung mengarahkan ke URL yang diisikan di bawah ini.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('report_cta_label')
                            ->label('Label Tombol di Navbar')
                            ->default('Pengaduan')
                            ->required()
                            ->maxLength(50),

                        Select::make('report_cta_type')
                            ->label('Tipe Tujuan')
                            ->options([
                                'url' => 'Link Website Eksternal / Portal Pengaduan (https://...)',
                                'page' => 'Halaman Internal Website (/slug)',
                                'whatsapp' => 'WhatsApp Resmi (wa.me)',
                                'email' => 'Email Resmi (mailto:)',
                            ])
                            ->default('url')
                            ->required(),

                        TextInput::make('report_cta_value')
                            ->label('Alamat Link / URL Tujuan Pengaduan')
                            ->placeholder('Contoh: https://lapor.go.id atau https://pengaduan.pariamankota.go.id')
                            ->helperText('Masukkan link URL lengkap (diawali https:// atau http://) menuju website pengaduan tujuan.')
                            ->rules([new SafeUrl(allowRelative: true)])
                            ->columnSpanFull()
                            ->required(),

                        Toggle::make('report_cta_new_tab')
                            ->label('Buka di Tab Baru (_blank)')
                            ->default(true),
                    ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $value = trim((string) ($state['report_cta_value'] ?? ''));
        $type = (string) ($state['report_cta_type'] ?? 'url');

        if (preg_match('#^https?://#i', $value) === 1) {
            $type = 'url';
        }

        Settings::set('report.cta_label', $state['report_cta_label'] ?? 'Pengaduan');
        Settings::set('report.cta_type', $type);
        Settings::set('report.cta_value', $value);
        Settings::set('report.cta_new_tab', (bool) ($state['report_cta_new_tab'] ?? true));

        Notification::make()
            ->title('Link Modul Pengaduan berhasil disimpan')
            ->success()
            ->send();
    }
}
