<?php

namespace InetStudio\Classifiers\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use InetStudio\Classifiers\Models\ClassifierModel;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Trait HasClassifiers
 * @package InetStudio\Classifiers\Models\Traits
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
     */
    public static function getClassifierClassName(): string
    {
        return ClassifierModel::class;
    }

    /**
     * Get all attached Classifiers to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function classifiers(): MorphToMany
    {
        return $this->morphToMany(static::getClassifierClassName(), 'classifierable')->withTimestamps();
    }

    /**
     * Attach the given Classifier(s) to the model.
     *
     * @param int|string|array|\ArrayAccess|ClassifierModel $classifiers
     *
     * @return void
     */
    public function setClassifiersAttribute($classifiers)
    {
        if (! $this->exists) {
            $this->queuedClassifiers = $classifiers;

            return;
        }

        $this->attachClassifiers($classifiers);
    }

    /**
     * Boot the Classifierable trait for a model.
     *
     * @return void
     */
    public static function bootHasClassifiers()
    {
        static::created(function (Model $classifierableModel) {
            if ($classifierableModel->queuedClassifiers) {
                $classifierableModel->attachClassifiers($classifierableModel->queuedClassifiers);
                $classifierableModel->queuedClassifiers = [];
            }
        });

        static::deleted(function (Model $classifierableModel) {
            $classifierableModel->syncClassifiers(null);
        });
    }

    /**
     * Get the Classifier list.
     *
     * @param string $keyColumn
     *
     * @return array
     */
    public function classifierList(string $keyColumn = 'id'): array
    {
        return $this->classifiers()->pluck('value', $keyColumn)->toArray();
    }

    /**
     * Scope query with all the given Classifiers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|string|array|\ArrayAccess|ClassifierModel $classifiers
     * @param string $column
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAllClassifiers(Builder $query, $classifiers, string $column = 'id'): Builder
    {
        $classifiers = static::isClassifiersStringBased($classifiers)
            ? $classifiers : static::hydrateClassifiers($classifiers)->pluck($column);

        collect($classifiers)->each(function ($classifier) use ($query, $column) {
            $query->whereHas('classifiers', function (Builder $query) use ($classifier, $column) {
                return $query->where($column, $classifier);
            });
        });

        return $query;
    }

    /**
     * Scope query with any of the given Classifiers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|string|array|\ArrayAccess|ClassifierModel $classifiers
     * @param string $column
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAnyClassifiers(Builder $query, $classifiers, string $column = 'id'): Builder
    {
        $classifiers = static::isClassifiersStringBased($classifiers)
            ? $classifiers : static::hydrateClassifiers($classifiers)->pluck($column);

        return $query->whereHas('classifiers', function (Builder $query) use ($classifiers, $column) {
            $query->whereIn($column, (array) $classifiers);
        });
    }

    /**
     * Scope query with any of the given Classifiers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|string|array|\ArrayAccess|ClassifierModel $classifiers
     * @param string $column
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithClassifiers(Builder $query, $classifiers, string $column = 'id'): Builder
    {
        return static::scopeWithAnyClassifiers($query, $classifiers, $column);
    }

    /**
     * Scope query without the given Classifiers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|string|array|\ArrayAccess|ClassifierModel $classifiers
     * @param string $column
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutClassifiers(Builder $query, $classifiers, string $column = 'slug'): Builder
    {
        $classifiers = static::isClassifiersStringBased($classifiers)
            ? $classifiers : static::hydrateClassifiers($classifiers)->pluck($column);

        return $query->whereDoesntHave('classifiers', function (Builder $query) use ($classifiers, $column) {
            $query->whereIn($column, (array) $classifiers);
        });
    }

    /**
     * Scope query without any Classifiers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutAnyClassifiers(Builder $query): Builder
    {
        return $query->doesntHave('classifiers');
    }

    /**
     * Attach the given Classifier(ies) to the model.
     *
     * @param int|string|array|\ArrayAccess|ClassifierModel $classifiers
     *
     * @return $this
     */
    public function attachClassifiers($classifiers)
    {
        static::setClassifiers($classifiers, 'syncWithoutDetaching');

        return $this;
    }

    /**
     * Sync the given Classifier(s) to the model.
     *
     * @param int|string|array|\ArrayAccess|ClassifierModel|null $classifiers
     *
     * @return $this
     */
    public function syncClassifiers($classifiers)
    {
        static::setClassifiers($classifiers, 'sync');

        return $this;
    }

    /**
     * Detach the given Classifier(s) from the model.
     *
     * @param int|string|array|\ArrayAccess|ClassifierModel $classifiers
     *
     * @return $this
     */
    public function detachClassifiers($classifiers)
    {
        static::setClassifiers($classifiers, 'detach');

        return $this;
    }

    /**
     * Determine if the model has any the given Classifiers.
     *
     * @param int|string|array|\ArrayAccess|ClassifierModel $classifiers
     *
     * @return bool
     */
    public function hasClassifier($classifiers): bool
    {
        // Single Classifier slug
        if (is_string($classifiers)) {
            return $this->classifiers->contains('slug', $classifiers);
        }

        // Single Classifier id
        if (is_int($classifiers)) {
            return $this->classifiers->contains('id', $classifiers);
        }

        // Single Classifier model
        if ($classifiers instanceof ClassifierModel) {
            return $this->classifiers->contains('slug', $classifiers->slug);
        }

        // Array of Classifier slugs
        if (is_array($classifiers) && isset($classifiers[0]) && is_string($classifiers[0])) {
            return ! $this->classifiers->pluck('slug')->intersect($classifiers)->isEmpty();
        }

        // Array of Classifier ids
        if (is_array($classifiers) && isset($classifiers[0]) && is_int($classifiers[0])) {
            return ! $this->classifiers->pluck('id')->intersect($classifiers)->isEmpty();
        }

        // Collection of Classifier models
        if ($classifiers instanceof Collection) {
            return ! $classifiers->intersect($this->classifiers->pluck('slug'))->isEmpty();
        }

        return false;
    }

    /**
     * Determine if the model has any the given Classifiers.
     *
     * @param int|string|array|\ArrayAccess|ClassifierModel $classifiers
     *
     * @return bool
     */
    public function hasAnyClassifier($classifiers): bool
    {
        return static::hasClassifier($classifiers);
    }

    /**
     * Determine if the model has all of the given Classifiers.
     *
     * @param int|string|array|\ArrayAccess|ClassifierModel $classifiers
     *
     * @return bool
     */
    public function hasAllClassifiers($classifiers): bool
    {
        // Single Classifier slug
        if (is_string($classifiers)) {
            return $this->classifiers->contains('slug', $classifiers);
        }

        // Single Classifier id
        if (is_int($classifiers)) {
            return $this->classifiers->contains('id', $classifiers);
        }

        // Single Classifier model
        if ($classifiers instanceof ClassifierModel) {
            return $this->classifiers->contains('slug', $classifiers->slug);
        }

        // Array of Classifier slugs
        if (is_array($classifiers) && isset($classifiers[0]) && is_string($classifiers[0])) {
            return $this->classifiers->pluck('slug')->count() === count($classifiers)
                && $this->classifiers->pluck('slug')->diff($classifiers)->isEmpty();
        }

        // Array of Classifier ids
        if (is_array($classifiers) && isset($classifiers[0]) && is_int($classifiers[0])) {
            return $this->classifiers->pluck('id')->count() === count($classifiers)
                && $this->classifiers->pluck('id')->diff($classifiers)->isEmpty();
        }

        // Collection of Classifier models
        if ($classifiers instanceof Collection) {
            return $this->classifiers->count() === $classifiers->count() && $this->classifiers->diff($classifiers)->isEmpty();
        }

        return false;
    }

    /**
     * Set the given Classifier(s) to the model.
     *
     * @param int|string|array|\ArrayAccess|ClassifierModel $classifiers
     * @param string $action
     *
     * @return void
     */
    protected function setClassifiers($classifiers, string $action)
    {
        // Fix exceptional event name
        $event = $action === 'syncWithoutDetaching' ? 'attach' : $action;

        // Hydrate Classifiers
        $classifiers = static::hydrateClassifiers($classifiers)->pluck('id')->toArray();

        // Fire the Classifier syncing event
        static::$dispatcher->dispatch("inetstudio.classifiers.{$event}ing", [$this, $classifiers]);

        // Set Classifiers
        $this->classifiers()->$action($classifiers);

        // Fire the Classifier synced event
        static::$dispatcher->dispatch("inetstudio.classifiers.{$event}ed", [$this, $classifiers]);
    }

    /**
     * Hydrate Classifiers.
     *
     * @param int|string|array|\ArrayAccess|ClassifierModel $classifiers
     *
     * @return \Illuminate\Support\Collection
     */
    protected function hydrateClassifiers($classifiers)
    {
        $isClassifiersStringBased = static::isClassifiersStringBased($classifiers);
        $isClassifiersIntBased = static::isClassifiersIntBased($classifiers);
        $field = $isClassifiersStringBased ? 'slug' : 'id';
        $className = static::getClassifierClassName();

        return $isClassifiersStringBased || $isClassifiersIntBased
            ? $className::query()->whereIn($field, (array) $classifiers)->get() : collect($classifiers);
    }

    /**
     * Determine if the given Classifier(s) are string based.
     *
     * @param int|string|array|\ArrayAccess|ClassifierModel $classifiers
     *
     * @return bool
     */
    protected function isClassifiersStringBased($classifiers)
    {
        return is_string($classifiers) || (is_array($classifiers) && isset($classifiers[0]) && is_string($classifiers[0]));
    }

    /**
     * Determine if the given Classifier(s) are integer based.
     *
     * @param int|string|array|\ArrayAccess|ClassifierModel $classifiers
     *
     * @return bool
     */
    protected function isClassifiersIntBased($classifiers)
    {
        return is_int($classifiers) || (is_array($classifiers) && isset($classifiers[0]) && is_int($classifiers[0]));
    }
}
