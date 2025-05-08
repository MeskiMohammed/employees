<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The user ID.
     *
     * @var int|null
     */
    public $userId;

    /**
     * The action performed.
     *
     * @var string
     */
    public $action;

    /**
     * The description of the action.
     *
     * @var string
     */
    public $description;

    /**
     * The model type.
     *
     * @var string|null
     */
    public $modelType;

    /**
     * The model ID.
     *
     * @var int|null
     */
    public $modelId;

    /**
     * Additional properties.
     *
     * @var array
     */
    public $properties;

    /**
     * Create a new event instance.
     */
    public function __construct(
        string $action, 
        string $description, 
        ?int $userId = null, 
        ?string $modelType = null, 
        ?int $modelId = null, 
        array $properties = []
    ) {
        $this->action = $action;
        $this->description = $description;
        $this->userId = $userId;
        $this->modelType = $modelType;
        $this->modelId = $modelId;
        $this->properties = $properties;
    }
}
