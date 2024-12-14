<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Faker\Factory as FakerFactory;
use Faker\Generator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Select::configureUsing(fn(Select $select) => $select->native(false));
        Field::configureUsing(fn(Field $input) => $input->translateLabel());

        Gate::define('fatwa-auth', function (User $user, Post $post) {
            return $user->id === $post->user_id;
        });

        $this->app->singleton(Generator::class, function () {
            return FakerFactory::create('ar_SA');
        });
    }
}
