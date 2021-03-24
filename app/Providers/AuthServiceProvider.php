<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Course' => 'App\Policies\CoursePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     * 
     * Defines a gate for updating courses which check that the authenticated user
     * is the author of the course.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        
        Gate::define('update-course',function($course){
            return $course->user_id === Auth::user()->id;
            
        });
    }
}
