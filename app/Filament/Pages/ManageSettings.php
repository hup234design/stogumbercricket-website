<?php

namespace App\Filament\Pages;

//use App\Filament\Forms\Components\MediaImagePicker;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use App\Filament\Forms\Components\MediaImagePicker;
use App\Filament\Support\CmsSettings;
use Closure;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use PHPUnit\Metadata\Group;
use RyanChandler\FilamentNavigation\Filament\Fields\NavigationSelect;

class ManageSettings extends Page
{

    protected static ?string $title = 'Settings';
    protected static ?string $navigationGroup = 'Site Management';
    protected static ?string $navigationIcon= 'heroicon-o-cog';

    protected static string $view = 'filament.pages.settings';

    public $state = [];

//    public static function shouldRegisterNavigation(): bool
//    {
//        return auth()->user()->hasRole('admin');
//    }

    public function mount(CmsSettings $settings)
    {
        $this->state = $settings->all();

        $requiredKeys = [
            "site_name" => config('app.name'),
            "default_banner_image_id" => "",
            "posts_slug" => "blog",
            "posts_title" => "Blog",
            "default_posts_image_id" => "",
            "secondary_footer_menu_id" => "",
            "primary_footer_menu_id" => "",
            "secondary_header_menu_id" => "",
            "primary_header_menu_id" => "",
            "contact_email" => "",
            "contact_address" => "",
            "contact_map" => "",
            "events_enabled" => false,
            "events_slug" => "events",
            "events_title" => "Events",
            "default_events_image_id" => "",
//            "fixtures_slug" => "fixtures",
//            "fixtures_title" => "Fixtures",
            "enquriry_recipients" => [],
            "default_seo_image_id" => "",
            "projects_enabled" => false,
            "projects_slug" => "projects",
            "projects_title" => "Projects",
        ];

        foreach ($requiredKeys as $key=>$value) {
            if (!array_key_exists($key, $this->state)) {
                $this->state[$key] = $value;
            }
        }

        $this->form->fill($this->state);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Tabs::make('Settings')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('General')
                        ->schema([
                            Forms\Components\Group::make()
                                ->schema([
                                    Forms\Components\TextInput::make('state.site_name')
                                        ->label('Site Name')
                                        ->required(),
                                    MediaImagePicker::make('state.default_banner_image_id')
                                        ->label('Default Header Image')
                                        ->conversion('banner')
                                        ->required(),
                                ])
                        ]),
                    Forms\Components\Tabs\Tab::make('Projects')
                        ->schema([
                            Forms\Components\Toggle::make('state.projects_enabled')
                                ->label('Enabled')
                                ->default(false)
                                ->live(true),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('state.projects_title')
                                    ->label('Title')
                                    ->required(),
                                Forms\Components\TextInput::make('state.projects_slug')
                                    ->label('Slug')
                                    ->required(),
                            ])
                                ->visible(fn (Forms\Get $get) => $get('state.projects_enabled'))
                        ]),
                    Forms\Components\Tabs\Tab::make('Events')
                        ->schema([
                            Forms\Components\Toggle::make('state.events_enabled')
                                ->label('Enabled')
                                ->default(false)
                                ->live(true),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('state.events_title')
                                    ->label('Title')
                                    ->required(),
                                Forms\Components\TextInput::make('state.events_slug')
                                    ->label('Slug')
                                    ->required(),
                                MediaImagePicker::make('state.default_events_image_id')
                                    ->label('Default Events Image')
                                    ->required(),
                            ])
                            ->visible(fn (Forms\Get $get) => $get('state.events_enabled'))
                        ]),
                    Forms\Components\Tabs\Tab::make('Posts')
                        ->schema([
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('state.posts_title')
                                    ->label('Title')
                                    ->required(),
                                Forms\Components\TextInput::make('state.posts_slug')
                                    ->label('Slug')
                                    ->required(),
                            ])->columnSpan(2),
                            MediaImagePicker::make('state.default_posts_image_id')
                                ->label('Default Posts Image')
                                ->required(),
                        ])
                        ->columns(3),
                    Forms\Components\Tabs\Tab::make('Contact')
                        ->schema([
                            Forms\Components\TextInput::make('state.contact_name')
                                ->label('Contact Name')
                                ->nullable(),
                            Forms\Components\TextInput::make('state.contact_email')
                                ->label('Email')
                                ->email()
                                ->nullable(),
                            Forms\Components\TextInput::make('state.contact_telephone')
                                ->label('Telephone')
                                ->nullable(),
                            Forms\Components\Textarea::make('state.contact_address')
                                ->label('Address')
                                ->rows(3)
                                ->nullable(),
                            Forms\Components\Textarea::make('state.contact_map')
                                ->label('Embedded Map Code')
                                ->rows(5)
                                ->nullable(),
                        ]),
//                    Forms\Components\Tabs\Tab::make('Fixtures')
//                        ->schema([
//                            Forms\Components\Group::make([
//                                Forms\Components\TextInput::make('state.fixtures_title')
//                                    ->label('Title')
//                                    ->required(),
//                                Forms\Components\TextInput::make('state.fixtures_slug')
//                                    ->label('Slug')
//                                    ->required(),
//                            ])
//                                ->columnSpan(2),
//                        ])
//                        ->columns(3),
                    Forms\Components\Tabs\Tab::make('Enquiries')
                        ->schema([
                            Forms\Components\Repeater::make('state.enquiry_recipients')
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->required(),
                                    Forms\Components\TextInput::make('email')
                                        ->email()
                                        ->required(),
                                ])->columns(2)
                        ]),
                    Forms\Components\Tabs\Tab::make('Navigation')
                        ->schema([
                            NavigationSelect::make('state.primary_header_menu_id')
                                ->label('Primary Header Menu')
                                ->required(),
                            NavigationSelect::make('state.secondary_header_menu_id')
                                ->label('Secondary Header Menu')
                                ->helperText('This will only be used if configured in site theme'),
                            NavigationSelect::make('state.primary_footer_menu_id')
                                ->label('Primary Footer Menu')
                                ->required(),
                            NavigationSelect::make('state.secondary_footer_menu_id')
                                ->label('Secondary Footer Menu')
                                ->helperText('This will only be used if configured in site theme'),
                        ]),
                    Forms\Components\Tabs\Tab::make('SEO')
                        ->schema([
                            MediaImagePicker::make('state.default_seo_image_id')
                                ->label('Default SEO Image')
                                ->conversion('seo')
                                ->required(),
                        ])
                ])
                ->columnSpan(2)
        ];
    }

    public function submit(CmsSettings $settings): void
    {
        $this->validate();
        $settings->put($this->state);

        Notification::make()
            ->title('Settings Saved successfully')
            ->success()
            ->send();
    }
}
