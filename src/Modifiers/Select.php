<?php

namespace FahlgrenDigital\ToolsForStatamic\Modifiers;

use Statamic\Facades\Compare;
use Statamic\Modifiers\Modifier;
use Statamic\Support\Arr;

class Select extends Modifier
{
    /**
     * Modify a value.
     *
     * @param mixed $value The value to be modified
     * @param array $params Any parameters used in the modifier
     * @param array $context Contextual values
     * @return mixed
     */
    public function index($value, $params, $context)
    {
        $keys = explode(',', $params[0]);

        if (!is_array($keys)) {
            $keys = [$keys];
        }

        if (($wasArray = is_array($value) && !Arr::isAssoc($value))) {
            $value = collect($value);
        }

        if (Compare::isQueryBuilder($value)) {
            $value = $value->get();
        }

        $items = $value->map(function ($item) use ($keys) {
            if (is_array($item)) {
                return Arr::only($item, $keys);
            }

            $data = [];
            foreach ($keys as $k) {
                $data[$k] = method_exists($item, 'value') ? $item->value($k) : $item->get($k);
            }

            return $data;
        });

        return $wasArray ? $items->all() : $items;
    }
}