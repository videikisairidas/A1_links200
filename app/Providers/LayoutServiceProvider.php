<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Resources\Json\JsonResource;


class LayoutServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        // $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
        // dd(auth()->user()->userProfile()->first_name);

        // get reason config images
        // View::composer('api_render.gallery.__reportButton', function ($view) {
        //     $data = $view->getData();
        //     $type = $data['type'] ?? 'image';
            
        //     $reasons = match($type) {
        //         'image' => config('_report.image.reason'),
        //         'submission' => config('_report.submission.reason'),
        //         default => [],
        //     };
        //     $view->with('reportReasons', $reasons);
        // });
        // View::composer('components.user._reportButton', function ($view) {
        //     $view->with('reportReasons', config('_report.user.reason'));
        // });
        // submission 
        // View::composer('api_render.gallery.__reportButton', function ($view) {
        //     $view->with('reportReasons', config('_report.submission.reason'));
        // });
        //user
    }
}
