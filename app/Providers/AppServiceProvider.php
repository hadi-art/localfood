<?php

namespace App\Providers;

use App\Permission;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Schema::defaultStringLength(191);

        //Get all menu permission names and routes and share them to the front page.
        view()->composer('parts.template',function($view){
            $menus = Permission::with(['allChilds'=>function($query){
                $query->where(['type'=>2,'discarded'=>0])->orderBy('sort');
            }])
                ->select(['id','parent_id','name','display_name','route_name','icons_name','descriptions','sort'])
                ->where('parent_id',0)
                ->where('type',2)
                ->where('discarded',0)
                ->orderBy('sort')
                ->get();
            $view->with('menus',$menus);
        });
//        $this->registerPolicies();
        Passport::routes();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
