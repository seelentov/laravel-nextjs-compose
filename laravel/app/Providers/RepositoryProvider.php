<?php

namespace App\Providers;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind(Articles\ArticlesRepository::class, function () {
        //     // Это полезно, если мы хотим выключить наш кластер
        //     // или при развертывании поиска на продакшене
        //     if (! config('services.search.enabled')) {
        //         return new Articles\EloquentRepository();
        //     }
        //     return new Articles\ElasticsearchRepository(
        //         $app->make(Client::class)
        //     );
        // });

        $this->bindSearchClient();
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
