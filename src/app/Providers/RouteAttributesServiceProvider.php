<?php

namespace App\Providers;

use Spatie\RouteAttributes\RouteAttributesServiceProvider as ServiceProvider;
use Spatie\RouteAttributes\RouteRegistrar;

class RouteAttributesServiceProvider extends ServiceProvider
{

    protected function registerRoutes(): void
    {
        if (! $this->shouldRegisterRoutes()) {
            return;
        }

        $routeRegistrar = (new RouteRegistrar(app()->router))
            ->useMiddleware(config('route-attributes.middleware') ?? []);

        collect(config('route-attributes.directories'))->each(function (string|array $directory, string|int $namespace) use ($routeRegistrar) {
            if (is_array($directory)) {
                // This is the main change
                $routeRegistrar->useRootNamespace($directory['namespace'] ?? app()->getNamespace());
                app()->router->group($directory, fn () => $routeRegistrar->registerDirectory($namespace));
            } else {
                is_string($namespace)
                    ? $routeRegistrar
                    ->useRootNamespace($namespace)
                    ->useBasePath($directory)
                    ->registerDirectory($directory)
                    : $routeRegistrar
                    ->useRootNamespace(app()->getNamespace())
                    ->useBasePath(app()->path())
                    ->registerDirectory($directory);
            }
        });
    }

    private function shouldRegisterRoutes(): bool
    {
        if (! config('route-attributes.enabled')) {
            return false;
        }

        if ($this->app->routesAreCached()) {
            return false;
        }

        return true;
    }
}
