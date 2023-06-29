<?php
namespace FahlgrenDigital\ToolsForStatamic;

use FahlgrenDigital\ToolsForStatamic\Modifiers\MakeResource;
use FahlgrenDigital\ToolsForStatamic\Tags\RandomString;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $modifiers = [
        MakeResource::class
    ];

    protected $tags = [
        RandomString::class
    ];
}