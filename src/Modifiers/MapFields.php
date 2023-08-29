<?php

namespace FahlgrenDigital\ToolsForStatamic\Modifiers;

use Illuminate\Support\Collection;
use Statamic\Entries\Entry;
use Statamic\Facades\Compare;
//use Statamic\Http\Resources\API\EntryResource;
//use Statamic\Http\Resources\API\TermResource;
use Statamic\Http\Resources\API\EntryResource;
use Statamic\Modifiers\Modifier;
use Statamic\Taxonomies\Term;

class MapFields extends Modifier
{
    public function index(mixed $value, array $params, array $context): mixed
    {
        $collection = is_array($value) ? collect($value) : $value;

        if (Compare::isQueryBuilder($value)) {
            $collection = $value->get();
        }

        if( !$this->isCollection($collection) ) {
            //todo throw some error
            return [];
        }



        return $collection->map(function (mixed $item) use($params){
            $new = [];
            foreach($params as $param) {
                if( $this->isEntryResource($item) ) {
                    $new[$param] = $param === 'id' ? $item->id : $item->get($param);
                } else {
                    $new[$param] = $item[$param];
                }
            }
            return $new;
        });
    }

//    protected function getByType($item)
//    {
//        if( $item instanceof Entry) {
//            return app(EntryResoucrce::class)::make($item);
//        }
//
//        if( $item instanceof Term) {
//            return app(TermResource::class)::make($item);
//        }
//
//        return $item;
//    }
//
    protected function isEntryResource($value): bool
    {
        return $value instanceof EntryResource;
    }

    protected function isCollection($value): bool
    {
        return $value instanceof Collection;
    }
}