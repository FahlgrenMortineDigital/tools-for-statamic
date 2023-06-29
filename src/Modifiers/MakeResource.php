<?php

namespace FahlgrenDigital\ToolsForStatamic\Modifiers;

use Statamic\Entries\Entry;
use Statamic\Facades\Compare;
use Statamic\Http\Resources\API\EntryResource;
use Statamic\Http\Resources\API\TermResource;
use Statamic\Modifiers\Modifier;
use Statamic\Taxonomies\Term;

class MakeResource extends Modifier
{
    public function index(mixed $value, array $params, array $context): mixed
    {
        //Item return item

        if (Compare::isQueryBuilder($value)) {
            return $value->get()->map(function($item) {
                return $this->getByType($item);
            });
        }

        if($this->isCollection($value)) {
            return $value->map(function($item) {
                return $this->getByType($item);
            });
        }

        return $this->getByType($value);
    }

    protected function getByType($item)
    {
        if( $item instanceof Entry) {
            return app(EntryResource::class)::make($item);
        }

        if( $item instanceof Term) {
            return app(TermResource::class)::make($item);
        }

        return $item;
    }

    protected function isCollection($value): bool
    {
        return $value instanceof \Statamic\Entries\EntryCollection
            || $value instanceof \Statamic\Taxonomies\TermCollection;
    }
}