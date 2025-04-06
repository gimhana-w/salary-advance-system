<?php

namespace App\Providers;

use App\Models\SalaryAdvanceRequest;
use App\Policies\SalaryAdvanceRequestPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        SalaryAdvanceRequest::class => SalaryAdvanceRequestPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
} 