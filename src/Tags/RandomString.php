<?php

namespace FahlgrenDigital\ToolsForStatamic\Tags;

use Statamic\Support\Str;
use Statamic\Tags\Tags;

class RandomString extends Tags
{
    /**
     * The {{ random_string }} tag.
     *
     * @return string|array
     */
    public function index()
    {
        $length = $this->params->get('length', 20);

        return Str::random($length);
    }

    /**
     * The {{ random_string:example }} tag.
     *
     * @return string|array
     */
    public function example()
    {
        //
    }
}
