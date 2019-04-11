<?php

namespace InetStudio\Classifiers\Models\Traits;

use ArrayAccess;
use Illuminate\Database\Eloquent\Collection;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;

/**
 * Trait HasClassifiers.
 */
trait HasClassifiersCollection
{
    /**
     * Determine if the model has any the given classifiers.
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
     * Determine if the model has any the given classifiers.
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
     * Determine if the model has all of the given classifiers.
     *
     * @param  int|string|array|ArrayAccess|EntryModelContract  $classifiers
     *
     * @return bool
     */
    public function hasAllClassifiers($classifiers): bool
    {
        if ($this->isClassifiersStringBased($classifiers)) {
            $classifiers = (array) $classifiers;

            return $this->classifiers->pluck('alias')->intersect($classifiers)->count() == count($classifiers);
        }

        if ($this->isClassifiersIntBased($classifiers)) {
            $classifiers = (array) $classifiers;

            return $this->classifiers->pluck('id')->intersect($classifiers)->count() == count($classifiers);
        }

        if ($classifiers instanceof EntryModelContract) {
            return $this->classifiers->contains('alias', $classifiers['alias']);
        }

        if ($classifiers instanceof Collection) {
            return $this->classifiers->intersect($classifiers)->count() == $classifiers->count();
        }

        return false;
    }

    /**
     * Determine if the given classifier(s) are string based.
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
     * Determine if the given classifier(s) are integer based.
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
