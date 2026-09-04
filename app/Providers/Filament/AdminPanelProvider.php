<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Navigation\NavigationGroup;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Blade; // Importante

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            
            // 1. PALETA DE CORES (Identidade Visual UniRovuma)
            ->colors([
                'primary' => Color::hex('#003366'),   
                'danger' => Color::hex('#e91e63'),    
                'warning' => Color::hex('#f39c12'),   
                'success' => Color::hex('#10b981'),   
                'info' => Color::hex('#0ea5e9'),      
                'gray' => Color::Slate,               
            ])

            // 2. LOGOTIPO DINÂMICO COM TEXTO (Utilizando a View criada)
            ->brandLogo(fn () => view('logo'))
            ->brandLogoHeight('3.5rem')
            ->favicon(asset('images/logo-rovuma.png'))

            // 3. ORGANIZAÇÃO DO MENU (Sincronizado com os nossos Resources)
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('ACADÉMICO') // Unidades, Áreas
                    ->icon('heroicon-o-academic-cap'),
                NavigationGroup::make()
                    ->label('PRODUÇÃO CIENTÍFICA') // Publicações, Projetos
                    ->icon('heroicon-o-beaker'),
                NavigationGroup::make()
                    ->label('PORTAL INSTITUCIONAL') // Notícias, Páginas, Menus
                    ->icon('heroicon-o-globe-alt'),
                NavigationGroup::make()
                    ->label('CONTROLE DE ACESSO') // Users, Roles
                    ->icon('heroicon-o-shield-check'),
                NavigationGroup::make()
                    ->label('CONFIGURAÇÃO')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(),
            ])

            // 4. REFINAMENTOS DE LAYOUT
            ->sidebarWidth('20rem')
            ->sidebarCollapsibleOnDesktop()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->maxContentWidth('full')
            ->font('Inter') 

            // 5. TÉCNICO
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                //Widgets\AccountWidget::class, // Widget pequeno do usuário (no topo)
                // Seus novos widgets:
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\ProjectsChart::class,
                \App\Filament\Widgets\LatestProjects::class,
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
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}