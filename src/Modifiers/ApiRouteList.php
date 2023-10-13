<?php

namespace FahlgrenDigital\ToolsForStatamic\Modifiers;

use Illuminate\Support\Collection;
use Statamic\Entries\Entry;
use Statamic\Facades\Compare;
use Statamic\Http\Resources\API\TermResource;
use Statamic\Modifiers\Modifier;
use Statamic\Taxonomies\Term;

class ApiRouteList extends Modifier
{
    /**
     * Modify a value.
     *
     * @param mixed  $value    The value to be modified
     * @param array  $params   Any parameters used in the modifier
     * @param array  $context  Contextual values
     * @return mixed
     */
    public function index($value, $params, $context)
    {
        //Item return item
        if (Compare::isQueryBuilder($value)) {
            $value = $value->get();
        }

        if($this->isCollection($value)) {
            return $this->mapCollectionValues($value);
        } else if(is_iterable($value)) {
            $value = collect($value);

            return $this->mapCollectionValues($value);
        }

        return $value;
    }

    private function mapCollectionValues(Collection $collection): Collection
    {
        return $collection->map(function($item) {
            return $item->apiUrl();
        });
    }

    protected function getByType($item)
    {
        if( $item instanceof Entry) {
            return $item->toArray();
//            return app(EntryResource::class)::make($item);
        }

        if( $item instanceof Term) {
            return app(TermResource::class)::make($item);
        }

        return $item;
    }

    protected function isCollection($value): bool
    {
        return $value instanceof Collection;
    }
}
