<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityLogged
{
    use Dispatchable, SerializesModels;

    public $userName;

    public $action;

    public $model;

    public $modelId;

    public $changes;

    public function __construct($userName, $action, $model = null, $modelId = null, $changes = null)
    {
        $this->userName = $userName;
        $this->action = $action;
        $this->model = $model;
        $this->modelId = $modelId;
        $this->changes = $changes;
    }
}
