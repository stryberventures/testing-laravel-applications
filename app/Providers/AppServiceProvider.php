<?php

namespace App\Providers;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientInterface::class, function ($app) {
            return new Guzzle([]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.debug')) {
            DB::listen(function ($query) {
                $location = collect(debug_backtrace())->filter(function ($trace) {
                    return array_key_exists('file', $trace)
                        && (
                            !str_contains($trace['file'], 'vendor/')
                            || str_contains($trace['file'], 'laravel/sanctum/src/Guard.php')
                        )
                    ;
                })->first();

                foreach ($query->bindings as $i => $binding) {
                    if ($binding instanceof \DateTime) {
                        $query->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                    } else {
                        if (is_string($binding)) {
                            $query->bindings[$i] = "'$binding'";
                        }
                    }
                }

                // Insert bindings into query
                $boundSql = str_replace(['%', '?'], ['%%', '%s'], $query->sql);
                $boundSql = vsprintf($boundSql, $query->bindings);

                // \Illuminate\Support\Facades\File::append(
                //     storage_path('/logs/query.log'),
                //     '[' . getmypid() . '] ' . $query->time . 'ms ' . ' | ' . $boundSql . PHP_EOL
                // );
                Log::info('query: ' . '[' . getmypid() . '] ' . $query->time . 'ms ' . ' | ' . $boundSql);
                Log::info('location: ' . $location['file'] . ':' . $location['line'] . "\n");
            });
        }
    }
}
