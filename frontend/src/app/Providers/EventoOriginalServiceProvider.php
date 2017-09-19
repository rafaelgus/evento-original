<?php
namespace App\Providers;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\Mapping\Entity;
use EventoOriginal\Core\Entities;
use EventoOriginal\Core\Persistence\Repositories;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;

class EventoOriginalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $menuRepository = $this->app->make(Repositories\MenuRepository::class);
        $menuItemRepository = $this->app->make(Repositories\MenuItemRepository::class);

        $navbarMenu = $menuRepository->findByType('navbar', App::getLocale());

        $navbarMenuItems = [];
        if ($navbarMenu) {
            $navbarMenuItems = $menuItemRepository->findByMenu($navbarMenu);
        }

        View::share('navBarMenuItems', $navbarMenuItems);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        define('CORE_DIR', realpath(__DIR__ . '/../../../../core/src'));

        AnnotationRegistry::registerAutoloadNamespace(
            'Gedmo\Mapping\Annotation',
            __DIR__ . '/vendor/gedmo'
        );


        $this->app->singleton(Repositories\UserRepository::class, function () {
            return EntityManager::getRepository(Entities\User::class);
        });
        $this->app->singleton(Repositories\ImageRepository::class, function () {
            return EntityManager::getRepository(Entities\Image::class);
        });
        $this->app->singleton(Repositories\ColorRepository::class, function () {
            return EntityManager::getRepository(Entities\Color::class);
        });
        $this->app->singleton(Repositories\AllergenRepository::class, function () {
            return EntityManager::getRepository(Entities\Allergen::class);
        });
        $this->app->singleton(Repositories\BrandRepository::class, function () {
            return EntityManager::getRepository(Entities\Brand::class);
        });
        $this->app->singleton(Repositories\CountryRepository::class, function () {
            return EntityManager::getRepository(Entities\Country::class);
        });
        $this->app->singleton(Repositories\CurrencyConversionRepository::class, function () {
            return EntityManager::getRepository(Entities\CurrencyConversion::class);
        });
        $this->app->singleton(Repositories\FlavourRepository::class, function () {
            return EntityManager::getRepository(Entities\Flavour::class);
        });
        $this->app->singleton(Repositories\TagRepository::class, function () {
            return EntityManager::getRepository(Entities\Tag::class);
        });
        $this->app->singleton(Repositories\ArticleRepository::class, function () {
            return EntityManager::getRepository(Entities\Article::class);
        });
        $this->app->singleton(Repositories\TaxRepository::class, function () {
            return EntityManager::getRepository(Entities\Tax::class);
        });
        $this->app->singleton(Repositories\CategoryRepository::class, function () {
            return EntityManager::getRepository(Entities\Category::class);
        });
        $this->app->singleton(Repositories\LicenseRepository::class, function () {
            return EntityManager::getRepository(Entities\License::class);
        });
        $this->app->singleton(Repositories\IngredientRepository::class, function () {
            return EntityManager::getRepository(Entities\Ingredient::class);
        });
        $this->app->singleton(Repositories\PriceRepository::class, function () {
            return EntityManager::getRepository(Entities\Price::class);
        });
        $this->app->singleton(Repositories\RoleRepository::class, function () {
            return EntityManager::getRepository(Entities\Role::class);
        });
        $this->app->singleton(Repositories\VoucherRepository::class, function() {
           return EntityManager::getRepository(Entities\Voucher::class);
        });
        $this->app->singleton(Repositories\HealthyRepository::class, function () {
            return EntityManager::getRepository(Entities\Healthy::class);
        });
        $this->app->singleton(Repositories\MenuRepository::class, function () {
            return EntityManager::getRepository(Entities\Menu::class);
        });
        $this->app->singleton(Repositories\MenuItemRepository::class, function () {
            return EntityManager::getRepository(Entities\MenuItem::class);
        });
        $this->app->singleton(Repositories\OrderDetailRepository::class, function () {
            return EntityManager::getRepository(Entities\OrderDetail::class);
        });
        $this->app->singleton(Repositories\OrderRepository::class, function () {
            return EntityManager::getRepository(Entities\Order::class);
        });
    }
}
