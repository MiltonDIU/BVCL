<?php

namespace App\Observers;

use App\Models\Service;
use App\Models\ServiceStatus;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
class ServiceActionObserver
{
    public function created(Service $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Service'];
        $users = User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function updated(Service $model)
    {
        $data  = ['action' => 'updated', 'model_name' => 'Service'];
        $users = User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
