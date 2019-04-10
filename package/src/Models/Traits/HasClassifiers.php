<?php

namespace InetStudio\Classifiers\Models\Traits;

use ArrayAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;

/**
 * Trait HasClassifiers.
 */
trait HasClassifiers
{
    /**
     * The Queued Classifiers.
     *
     * @var array
     */
    protected $queuedClassifiers = [];

    /**
     * Get Classifier class name.
     * 
     * @return string
     * 
     * @throws BindingResolutionException
     */
    public function getClassifierClassName(): string
    {
        $model = app()->make(EntryModelContract::class);

        return get_class($model);
    }

    /**
     * Get all attached Classifiers to the model.
     *
     * @return MorphToMany
     *
     * @throws BindingResolutionException
     */
    public function classifiers(): MorphToMany
    {
        $className = $this->getClassifierClassName();

        return $this->morphToMany($className, 'classifierable')->withTimestamps();
    }

    /**
     * Attach the given Classifier(s) to the model.
     *
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     *
     * @throws BindingResolutionException
     */
    public function setClassifiersAttribute($classifiers): void
    {
        if (! $this->exists) {
            $this->queuedClassifiers = $classifiers;

            return;
        }

        $this->attachClassifiers($classifiers);
    }

    /**
     * Boot the Classifierable trait for a model.
     */
    public static function bootHasClassifiers()
    {
        static::created(
            function (Model $classifierableModel) {
                if ($classifierableModel->queuedClassifiers) {
                    $classifierableModel->attachClassifiers($classifierableModel->queuedClassifiers);
                    $classifierableModel->queuedClassifiers = [];
                }
            }
        );

        static::deleted(
            function (Model $classifierableModel) {
                $classifierableModel->syncClassifiers(null);
            }
        );
    }

    /**
     * Get the Classifier list.
     *
     * @param  string  $keyColumn
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function classifierList(string $keyColumn = 'id'): array
    {
        return $this->classifiers()->pluck('value', $keyColumn)->toArray();
    }

    /**
     * Scope query with all the given Classifiers.
     *
     * @param  Builder  $query
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     * @param  string  $column
     *
     * @return Builder
     *
     * @throws BindingResolutionException
     */
    public function scopeWithAllClassifiers(Builder $query, $classifiers, string $column = 'id'): Builder
    {
        $classifiers = $this->isClassifiersStringBased($classifiers)
            ? $classifiers : $this->hydrateClassifiers($classifiers)->pluck($column);

        collect($classifiers)->each(
            function ($classifier) use ($query, $column) {
                $query->whereHas(
                    'classifiers',
                    function (Builder $query) use ($classifier, $column) {
                        return $query->where($column, $classifier);
                    }
                );
            }
        );

        return $query;
    }

    /**
     * Scope query with any of the given Classifiers.
     *
     * @param  Builder  $query
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     * @param  string  $column
     *
     * @return Builder
     *
     * @throws BindingResolutionException
     */
    public function scopeWithAnyClassifiers(Builder $query, $classifiers, string $column = 'id'): Builder
    {
        $classifiers = $this->isClassifiersStringBased($classifiers)
            ? $classifiers : $this->hydrateClassifiers($classifiers)->pluck($column);

        return $query->whereHas(
            'classifiers',
            function (Builder $query) use ($classifiers, $column) {
                $query->whereIn($column, (array) $classifiers);
            }
        );
    }

    /**
     * Scope query with any of the given Classifiers.
     *
     * @param  Builder  $query
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     * @param  string  $column
     *
     * @return Builder
     *
     * @throws BindingResolutionException
     */
    public function scopeWithClassifiers(Builder $query, $classifiers, string $column = 'id'): Builder
    {
        return $this->scopeWithAnyClassifiers($query, $classifiers, $column);
    }

    /**
     * Scope query without the given Classifiers.
     *
     * @param  Builder  $query
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     * @param  string  $column
     *
     * @return Builder
     *
     * @throws BindingResolutionException
     */
    public function scopeWithoutClassifiers(Builder $query, $classifiers, string $column = 'alias'): Builder
    {
        $classifiers = $this->isClassifiersStringBased($classifiers)
            ? $classifiers : $this->hydrateClassifiers($classifiers)->pluck($column);

        return $query->whereDoesntHave(
            'classifiers',
            function (Builder $query) use ($classifiers, $column) {
                $query->whereIn($column, (array) $classifiers);
            }
        );
    }

    /**
     * Scope query without any Classifiers.
     *
     * @param  Builder  $query
     *
     * @return Builder
     */
    public function scopeWithoutAnyClassifiers(Builder $query): Builder
    {
        return $query->doesntHave('classifiers');
    }

    /**
     * Attach the given Classifier(ies) to the model.
     *
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     *
     * @return $this
     *
     * @throws BindingResolutionException
     */
    public function attachClassifiers($classifiers)
    {
        $this->setClassifiers($classifiers, 'syncWithoutDetaching');

        return $this;
    }

    /**
     * Sync the given Classifier(s) to the model.
     *
     * @param  int|string|array|ArrayAccess|EntryModelContract|null  $classifiers
     *
     * @return $this
     *
     * @throws BindingResolutionException
     */
    public function syncClassifiers($classifiers)
    {
        $this->setClassifiers($classifiers, 'sync');

        return $this;
    }

    /**
     * Detach the given Classifier(s) from the model.
     *
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     *
     * @return $this
     *
     * @throws BindingResolutionException
     */
    public function detachClassifiers($classifiers)
    {
        $this->setClassifiers($classifiers, 'detach');

        return $this;
    }

    /**
     * Determine if the model has any the given Classifiers.
     *
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     *
     * @return bool
     */
    public function hasClassifier($classifiers): bool
    {
        if ($this->isClassifiersStringBased($classifiers)) {
            return ! $this->classifiers->pluck('alias')->intersect((array) $classifiers)->isEmpty();
        }

        if ($this->isClassifiersIntBased($classifiers)) {
            return ! $this->classifiers->pluck('id')->intersect((array) $classifiers)->isEmpty();
        }

        if ($classifiers instanceof EntryModelContract) {
            return $this->classifiers->contains('alias', $classifiers['alias']);
        }

        // Collection of Classifier models
        if ($classifiers instanceof Collection) {
            return ! $classifiers->intersect($this->classifiers->pluck('alias'))->isEmpty();
        }

        return false;
    }

    /**
     * Determine if the model has any the given Classifiers.
     *
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     *
     * @return bool
     */
    public function hasAnyClassifier($classifiers): bool
    {
        return $this->hasClassifier($classifiers);
    }

    /**
     * Determine if the model has all of the given Classifiers.
     *
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     *
     * @return bool
     */
    public function hasAllClassifiers($classifiers): bool
    {
        if (is_string($classifiers)) {
            return $this->classifiers->contains('alias', $classifiers);
        }

        // Single Classifier id
        if (is_int($classifiers)) {
            return $this->classifiers->contains('id', $classifiers);
        }

        // Single Classifier model
        if ($classifiers instanceof EntryModelContract) {
            return $this->classifiers->contains('alias', $classifiers['alias']);
        }

        // Array of Classifier aliases
        if (is_array($classifiers) && isset($classifiers[0]) && is_string($classifiers[0])) {
            return $this->classifiers->pluck('alias')->count() === count($classifiers)
                && $this->classifiers->pluck('alias')->diff($classifiers)->isEmpty();
        }

        // Array of Classifier ids
        if (is_array($classifiers) && isset($classifiers[0]) && is_int($classifiers[0])) {
            return $this->classifiers->pluck('id')->count() === count($classifiers)
                && $this->classifiers->pluck('id')->diff($classifiers)->isEmpty();
        }

        // Collection of Classifier models
        if ($classifiers instanceof Collection) {
            return $this->classifiers->count() === $classifiers->count() && $this->classifiers->diff(
                    $classifiers
                )->isEmpty();
        }

        return false;
    }

    /**
     * Set the given Classifier(s) to the model.
     *
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     * @param  string  $action
     *
     * @throws BindingResolutionException
     */
    protected function setClassifiers($classifiers, string $action): void
    {
        // Fix exceptional event name
        $event = $action === 'syncWithoutDetaching' ? 'attach' : $action;

        // Hydrate Classifiers
        $classifiers = $this->hydrateClassifiers($classifiers)->pluck('id')->toArray();

        // Fire the Classifier syncing event
        static::$dispatcher->dispatch('inetstudio.classifiers.entries.'.$event.'ing', [$this, $classifiers]);

        // Set Classifiers
        $this->classifiers()->$action($classifiers);

        // Fire the Classifier synced event
        static::$dispatcher->dispatch('inetstudio.classifiers.entries.'.$event.'ed', [$this, $classifiers]);
    }

    /**
     * Hydrate Classifiers.
     *
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     *
     * @return Collection
     *
     * @throws BindingResolutionException
     */
    protected function hydrateClassifiers($classifiers): Collection
    {
        $isClassifiersStringBased = $this->isClassifiersStringBased($classifiers);
        $isClassifiersIntBased = $this->isClassifiersIntBased($classifiers);
        $field = $isClassifiersStringBased ? 'alias' : 'id';
        $className = $this->getClassifierClassName();

        return $isClassifiersStringBased || $isClassifiersIntBased
            ? $className::query()->whereIn($field, (array) $classifiers)->get() : collect($classifiers);
    }

    /**
     * Determine if the given Classifier(s) are string based.
     *
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     *
     * @return bool
     */
    protected function isClassifiersStringBased($classifiers): bool
    {
        return is_string($classifiers) || (is_array($classifiers) && isset($classifiers[0]) && is_string(
                    $classifiers[0]
                ));
    }

    /**
     * Determine if the given Classifier(s) are integer based.
     *
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     *
     * @return bool
     */
    protected function isClassifiersIntBased($classifiers)
    {
        return is_int($classifiers) || (is_array($classifiers) && isset($classifiers[0]) && is_int($classifiers[0]));
    }
}
