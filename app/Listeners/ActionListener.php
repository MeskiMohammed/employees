<?php

namespace App\Listeners;

use App\Events\ActionEvent;
use App\Models\Event;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Request;

class ActionListener
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(ActionEvent $event): void
    {
        Event::create([
            'user_id' => $event->userId,
            'action' => $event->action,
            'description' => $event->description,
            'model_type' => $event->modelType,
            'model_id' => $event->modelId,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'properties' => $event->properties,
        ]);
    }
}
