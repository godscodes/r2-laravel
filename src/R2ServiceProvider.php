<?php namespace godscodes\R2Laravel;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Aws\Laravel\AwsServiceProvider;
use Storage;
/**
 * R2 SDK for PHP service provider for Laravel applications
 */
class R2ServiceProvider extends ServiceProvider
{
    const VERSION = '1.0.0';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the configuration
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('s3', function($app, $config) {
            $client = new S3Client([
                'credentials' => [
                    'key'    => $config['key'],
                    'secret' => $config['secret'],
                ],
                'region' => $config['region'],
                'version' => config('R2Laravel.version'),
                'endpoint' => config('R2Laravel.endpoint'),
                'ua_append' => [
                    'L5MOD/' . AwsServiceProvider::VERSION,
                ],
            ]);

            return new Filesystem(new AwsS3Adapter($client, config('R2Laravel.account_id'), config('R2Laravel.bucket_name')));
        });
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes(
                [__DIR__.'/../config/r2_publish.php' => config_path('R2Laravel.php')],
                'r2-config'
            );
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('r2');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/r2_default.php',
            'r2'
        );

        $this->app->singleton('r2', function ($app) {
            $config = $app->make('config')->get('r2');

            return new Sdk($config);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['r2'];
    }

}