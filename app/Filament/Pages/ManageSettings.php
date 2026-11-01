<?php

namespace App\Filament\Pages;

use App\Rules\SafeUrl;
use App\Support\Settings;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageSettings extends Page
{
    protected string $view = 'filament.pages.manage-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Navigasi & Sistem';

    protected static ?string $navigationLabel = 'Pengaturan & Pengaduan';

    protected static ?string $title = 'Pengaturan Situs & Modul Pengaduan';

    protected static ?int $navigationSort = 3;

    public ?array $data = [];

    private const KEY_MAP = [
        'site_name' => 'site.name',
        'site_tagline' => 'site.tagline',
        'site_logo' => 'site.logo',
        'hero_title' => 'hero.title',
        'hero_subtitle' => 'hero.subtitle',
        'hero_image' => 'hero.image',
        'hero_image_alt' => 'hero.image_alt',
        'contact_address' => 'contact.address',
        'contact_phone' => 'contact.phone',
        'contact_emergency_phone' => 'contact.emergency_phone',
        'contact_email_security' => 'contact.email_security',
        'contact_hours' => 'contact.hours',
        'pgp_fingerprint' => 'pgp.fingerprint',
        'security_policy_url' => 'security.policy_url',
        'security_expires' => 'security.expires',
        'footer_text' => 'footer.text',
        'report_cta_label' => 'report.cta_label',
        'report_cta_type' => 'report.cta_type',
        'report_cta_value' => 'report.cta_value',
        'report_cta_new_tab' => 'report.cta_new_tab',
        'report_channels' => 'report.channels',
        'report_warning' => 'report.warning',
        'emergency_enabled' => 'emergency.enabled',
        'emergency_text' => 'emergency.text',
        'emergency_level' => 'emergency.level',
    ];

    /**
     * Pastikan hanya superadmin dan koordinator yang dapat mengakses pengaturan.
     */
    public static function canAccess(): bool
    {
        $user = auth()->user();

        return $user && $user->hasAnyRole(['superadmin', 'koordinator']);
    }

    public function mount(): void
    {
        $formData = [];
        foreach (self::KEY_MAP as $field => $key) {
            $formData[$field] = Settings::get($key);
        }

        $rawChecklist = Settings::get('report.checklist', []);
        $formData['report_checklist'] = array_map(function ($item) {
            return is_array($item) ? $item : ['item' => $item];
        }, (array) $rawChecklist);

        $this->form->fill($formData);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make('Pengaturan Portal CSIRT')
                    ->tabs([
                        Tab::make('Identitas')
                            ->icon(Heroicon::BuildingOffice)
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Nama Situs')
                                    ->required()
                                    ->default('CSIRT Kota Pariaman'),
                                TextInput::make('site_tagline')
                                    ->label('Slogan / Tagline')
                                    ->default('Aman bersama di ruang digital Pariaman'),
                                FileUpload::make('site_logo')
                                    ->label('Logo Instansi / Pemko Pariaman')
                                    ->disk('public')
                                    ->directory('logo')
                                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                                    ->maxSize(4096)
                                    ->helperText('Logo yang ditampilkan di Header dan Footer situs (Format PNG transparan disarankan).'),
                                TextInput::make('hero_title')
                                    ->label('Judul Utama Hero')
                                    ->default('Aman bersama di ruang digital Pariaman'),
                                Textarea::make('hero_subtitle')
                                    ->label('Subjudul / Deskripsi Singkat Hero')
                                    ->rows(3),
                                FileUpload::make('hero_image')
                                    ->label('Foto Sampul Beranda (Hero Banner)')
                                    ->disk('public')
                                    ->directory('hero')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->maxSize(6144)
                                    ->helperText('Unggah foto sampul untuk ditampilkan di sisi kanan Hero Beranda (Format JPG, PNG, atau WEBP maks 6 MB).'),
                                TextInput::make('hero_image_alt')
                                    ->label('Keterangan / Teks Alternatif Foto Sampul Beranda')
                                    ->default('Foto Sampul CSIRT Pemerintah Kota Pariaman'),
                                TextInput::make('footer_text')
                                    ->label('Teks Hak Cipta Footer')
                                    ->default('© Diskominfo Kota Pariaman'),
                            ]),

                        Tab::make('Kontak & Jam Kerja')
                            ->icon(Heroicon::Phone)
                            ->schema([
                                TextInput::make('contact_address')
                                    ->label('Alamat Kantor')
                                    ->placeholder('[ISI: alamat kantor]'),
                                TextInput::make('contact_phone')
                                    ->label('Nomor Telepon Kantor')
                                    ->placeholder('[ISI: telepon]'),
                                TextInput::make('contact_emergency_phone')
                                    ->label('Nomor Telepon Darurat (Hotline)')
                                    ->placeholder('[ISI: nomor darurat]'),
                                TextInput::make('contact_email_security')
                                    ->label('Email Keamanan (security@...)')
                                    ->placeholder('[ISI: email keamanan]')
                                    ->helperText('Bila valid, email ini akan mengaktifkan rute /.well-known/security.txt'),
                                TextInput::make('contact_hours')
                                    ->label('Jam Layanan')
                                    ->placeholder('[ISI: jam layanan]'),
                            ]),

                        Tab::make('Keamanan & PGP')
                            ->icon(Heroicon::Key)
                            ->schema([
                                TextInput::make('pgp_fingerprint')
                                    ->label('Fingerprint Kunci PGP')
                                    ->placeholder('[ISI: fingerprint PGP]'),
                                TextInput::make('security_policy_url')
                                    ->label('URL Kebijakan Keamanan (Security Policy URL)')
                                    ->rules([new SafeUrl(allowRelative: false)])
                                    ->helperText('Contoh: https://csirt.pariamankota.go.id/kebijakan-keamanan (skema javascript: dan data: dilarang)'),
                                DatePicker::make('security_expires')
                                    ->label('Tanggal Kedaluwarsa security.txt'),
                            ]),

                        Tab::make('Modul Pengaduan (Link Navbar)')
                            ->icon(Heroicon::ExclamationTriangle)
                            ->schema([
                                Section::make('Tombol "Pengaduan" di Navbar & Beranda')
                                    ->description('Mengatur label dan link URL tujuan saat pengunjung menekan tombol Pengaduan di navbar atas maupun beranda.')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('report_cta_label')
                                            ->label('Label Tombol di Navbar')
                                            ->default('Pengaduan')
                                            ->required(),
                                        Select::make('report_cta_type')
                                            ->label('Jenis Tujuan Link')
                                            ->options([
                                                'url' => 'Link Website Eksternal / Portal Pengaduan (https://...)',
                                                'page' => 'Halaman Internal Website (/slug)',
                                                'whatsapp' => 'Buka WhatsApp (wa.me)',
                                                'email' => 'Buka Email (mailto:)',
                                            ])
                                            ->default('url')
                                            ->required(),
                                        TextInput::make('report_cta_value')
                                            ->label('Alamat Link URL Tujuan Pengaduan')
                                            ->placeholder('Contoh: https://lapor.go.id atau https://pengaduan.pariamankota.go.id')
                                            ->helperText('Masukkan alamat lengkap URL website pengaduan (diawali https:// atau http://) yang akan dituju saat tombol Pengaduan diklik.')
                                            ->default('saluran-pelaporan')
                                            ->columnSpanFull()
                                            ->required(),
                                        Toggle::make('report_cta_new_tab')
                                            ->label('Buka Link Pengaduan di Tab Baru')
                                            ->default(true),
                                    ]),

                                Section::make('Daftar Kartu Kanal Pelaporan')
                                    ->schema([
                                        Repeater::make('report_channels')
                                            ->label('Kanal Pelaporan')
                                            ->columns(4)
                                            ->schema([
                                                Select::make('type')
                                                    ->label('Tipe')
                                                    ->options([
                                                        'email' => 'Email',
                                                        'whatsapp' => 'WhatsApp',
                                                        'phone' => 'Telepon',
                                                        'url' => 'Tautan / Portal',
                                                    ])
                                                    ->required(),
                                                TextInput::make('label')
                                                    ->label('Label Kanal')
                                                    ->required(),
                                                TextInput::make('value')
                                                    ->label('Nilai / Kontak')
                                                    ->required(),
                                                TextInput::make('hours')
                                                    ->label('Jam Operasional'),
                                                Toggle::make('enabled')
                                                    ->label('Aktif')
                                                    ->default(true),
                                            ]),
                                    ]),

                                Section::make('Panduan Pelaporan & Peringatan')
                                    ->schema([
                                        Repeater::make('report_checklist')
                                            ->label('Daftar Periksa "Siapkan Informasi Ini"')
                                            ->schema([
                                                TextInput::make('item')->label('Poin Informasi')->required(),
                                            ]),
                                        Textarea::make('report_warning')
                                            ->label('Peringatan Keamanan')
                                            ->rows(2)
                                            ->default('Jangan pernah mengirim kata sandi, token autentikasi, atau kode OTP melalui kanal pelaporan apa pun.'),
                                    ]),
                            ]),

                        Tab::make('Banner Darurat')
                            ->icon(Heroicon::Megaphone)
                            ->schema([
                                Toggle::make('emergency_enabled')
                                    ->label('Aktifkan Banner Darurat di Seluruh Situs')
                                    ->default(false),
                                Select::make('emergency_level')
                                    ->label('Tingkat Keparahan Banner')
                                    ->options([
                                        'info' => 'Informasi (Biru)',
                                        'warning' => 'Peringatan (Kuning/Emas)',
                                        'danger' => 'Bahaya / Kritis (Merah)',
                                    ])
                                    ->default('warning'),
                                Textarea::make('emergency_text')
                                    ->label('Isi Pesan Banner')
                                    ->rows(3)
                                    ->placeholder('Contoh: Sedang terjadi peningkatan serangan phishing, harap waspada...'),
                            ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach (self::KEY_MAP as $field => $key) {
            if (array_key_exists($field, $state)) {
                Settings::set($key, $state[$field]);
            }
        }

        if (isset($state['report_checklist'])) {
            $checklist = array_values(array_filter(array_map(function ($row) {
                return is_array($row) ? ($row['item'] ?? '') : (string) $row;
            }, $state['report_checklist'])));

            Settings::set('report.checklist', $checklist);
        }

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
