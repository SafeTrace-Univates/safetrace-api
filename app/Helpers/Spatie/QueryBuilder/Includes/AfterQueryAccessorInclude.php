<?php

namespace App\Helpers\Spatie\QueryBuilder\Includes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Includes\IncludeInterface;

class AfterQueryAccessorInclude implements IncludeInterface
{
    public function __invoke(Builder $query, string $include)
    {
        if (substr_count($include, '.') > 1) {
            return;
        }

        $query->afterQuery(function (Collection $results) use ($include) {
            if (strpos($include, '.') === false) {
                foreach ($results as $model) {
                    $this->handleSingleInclude($model, $include);
                }
            } else {
                [$relation, $attribute] = explode('.', $include, 2);
                foreach ($results as $model) {
                    $this->handleNestedInclude($model, $relation, $attribute);
                }
            }
        });
    }

    protected function handleSingleInclude(Model $model, string $relation): void
    {
        $accessor = 'get' . ucfirst($relation) . 'Attribute';

        if (method_exists($model, $accessor)) {
            $value = $model->$relation;

            $model->setRelation($relation, $value);
        } else {
            $model->loadMissing($relation);
        }
    }

    protected function handleNestedInclude(Model $model, string $relation, string $attribute): void
    {
        $model->loadMissing($relation);

        $children = $model->getRelation($relation);
        $items    = $children instanceof Collection
                ? $children
                : collect([$children]);

        $items->each(function (Model $child) use ($attribute) {
            $child->$attribute;

            $child->append($attribute);
        });

        $model->setRelation(
            $relation,
            $children instanceof Collection ? $items : $items->first(),
        );
    }
}
