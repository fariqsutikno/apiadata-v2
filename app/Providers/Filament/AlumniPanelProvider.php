<?php

namespace App\Providers\Filament;

use App\Filament\Alumni\Resources\AlumniResource\Pages\EditProfile;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Pages\Auth\Login;
use Filament\Pages\Auth\Signin;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;

class AlumniPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('alumni')
            ->path('alumni')
            ->login()
            ->profile(isSimple:false)
            ->colors([
                'primary' => Color::Rose,
            ])
            // ->topNavigation()
            ->discoverResources(in: app_path('Filament/Alumni/Resources'), for: 'App\\Filament\\Alumni\\Resources')
            ->discoverPages(in: app_path('Filament/Alumni/Pages'), for: 'App\\Filament\\Alumni\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([
                Pages\Dashboard::class,
                EditProfile::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Alumni/Widgets'), for: 'App\\Filament\\Alumni\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
                // FilamentEditProfilePlugin::make()
                // // ->slug('my-profile')
                // ->setTitle('My Profile')
                // ->setNavigationLabel('My Profile')
                // ->setNavigationGroup('Group Profile')
                // ->setIcon('heroicon-o-user')
                // // ->setSort(10)
                // // // ->canAccess(fn () => auth()->user()->id === 1)
                // // ->shouldRegisterNavigation(false)
                // ->shouldShowDeleteAccountForm(false)
                // // ->shouldShowSanctumTokens()
                // // ->shouldShowBrowserSessionsForm()
                // ->shouldShowAvatarForm(
                //     value: true,
                //     directory: 'avatars', // image will be stored in 'storage/app/public/avatars
                //     rules: 'mimes:jpeg,png|max:1024' //only accept jpeg and png files with a maximum size of 1MB
                // )
                // ->customProfileComponents([
                //     // \App\Livewire\CustomProfileComponent::class,
                // ]),
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn() => auth()->user()->name)
                    // ->url(fn (): string => route(EditProfile::getRouteName(panel: 'alumni')))
                    ->icon('heroicon-m-user-circle'),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
