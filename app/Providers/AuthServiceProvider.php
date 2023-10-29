<?php

namespace App\Providers;

use App\Models\BorrowDevice;
use App\Policies\BorrowDevicePolicy;

use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Room;
use App\Models\Department;
use App\Policies\DevicePolicy;
use App\Policies\DeviceTypePolicy;
use App\Policies\RoomPolicy;
use App\Policies\DepartmentPolicy;
// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Policies\UserPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        BorrowDevice::class => BorrowDevicePolicy::class,
        Borrow::class => BorrowPolicy::class,
        Device::class => DevicePolicy::class,
        DeviceType::class => DeviceTypePolicy::class,
        Room::class => RoomPolicy::class,
        User::class => UserPolicy::class,
        Department::class => DepartmentPolicy::class,
    ];


    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}