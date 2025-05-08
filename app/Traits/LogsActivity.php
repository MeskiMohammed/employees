<?php

namespace App\Traits;

use App\Events\ActionEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Log an action.
     *
     * @param string $action
     * @param string $description
     * @param Model|null $model
     * @param array $properties
     * @return void
     */
    protected function logActivity(string $action, string $description, ?Model $model = null, array $properties = []): void
    {
        $userId = Auth::id();
        $modelType = $model ? get_class($model) : null;
        $modelId = $model ? $model->id : null;

        event(new ActionEvent(
            $action,
            $description,
            $userId,
            $modelType,
            $modelId,
            $properties
        ));
    }

    /**
     * Log a creation action.
     *
     * @param Model $model
     * @param string|null $customDescription
     * @param array $properties
     * @return void
     */
    protected function logCreation(Model $model, ?string $customDescription = null, array $properties = []): void
    {
        $modelName = class_basename($model);
        $description = $customDescription ?? "{$modelName} created with ID: {$model->id}";
        
        $this->logActivity('created', $description, $model, $properties);
    }

    /**
     * Log an update action.
     *
     * @param Model $model
     * @param string|null $customDescription
     * @param array $properties
     * @return void
     */
    protected function logUpdate(Model $model, ?string $customDescription = null, array $properties = []): void
    {
        $modelName = class_basename($model);
        $description = $customDescription ?? "{$modelName} updated with ID: {$model->id}";
        
        $this->logActivity('updated', $description, $model, $properties);
    }

    /**
     * Log a deletion action.
     *
     * @param Model $model
     * @param string|null $customDescription
     * @param array $properties
     * @return void
     */
    protected function logDeletion(Model $model, ?string $customDescription = null, array $properties = []): void
    {
        $modelName = class_basename($model);
        $description = $customDescription ?? "{$modelName} deleted with ID: {$model->id}";
        
        $this->logActivity('deleted', $description, $model, $properties);
    }

    /**
     * Log a view action.
     *
     * @param Model $model
     * @param string|null $customDescription
     * @param array $properties
     * @return void
     */
    protected function logView(Model $model, ?string $customDescription = null, array $properties = []): void
    {
        $modelName = class_basename($model);
        $description = $customDescription ?? "{$modelName} viewed with ID: {$model->id}";
        
        $this->logActivity('viewed', $description, $model, $properties);
    }

    /**
     * Log a custom action.
     *
     * @param string $action
     * @param string $description
     * @param Model|null $model
     * @param array $properties
     * @return void
     */
    protected function logCustomAction(string $action, string $description, ?Model $model = null, array $properties = []): void
    {
        $this->logActivity($action, $description, $model, $properties);
    }
}
