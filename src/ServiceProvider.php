<?php
namespace FahlgrenDigital\ToolsForStatamic;

use FahlgrenDigital\ToolsForStatamic\Modifiers\MakeResource;
use FahlgrenDigital\ToolsForStatamic\Modifiers\MapFields;
use FahlgrenDigital\ToolsForStatamic\Modifiers\Select;
use FahlgrenDigital\ToolsForStatamic\Tags\RandomString;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $modifiers = [
        MakeResource::class,
        MapFields::class,
        Select::class,
    ];

    protected $tags = [
        RandomString::class
    ];
}