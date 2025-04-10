<?php

namespace App\Listeners;

use App\Events\ActivityLogged;
use App\Models\ActivityLog;

class LogActivity
{
    public function handle(ActivityLogged $event)
    {
        ActivityLog::create([
            'user_name' => $event->userName,
            'action' => $event->action,
            'model' => $event->model,
            'model_id' => $event->modelId,
            'changes' => $event->changes ? json_encode($event->changes) : null,
        ]);
    }
}
