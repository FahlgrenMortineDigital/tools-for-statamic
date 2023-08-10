<?php

namespace FahlgrenDigital\ToolsForStatamic\Support;

use Statamic\Contracts\Assets\Asset as AssetContract;
use Statamic\Contracts\Imaging\ImageManipulator;
use Statamic\Facades\Asset;
use Statamic\Facades\Config;
use Statamic\Facades\Image;
use Statamic\Fields\Value;
use Statamic\Imaging\GlideImageManipulator;
use Statamic\Support\Str;

class GlideSupport
{
    public static function buildUrl(ImageManipulator $manipulator): ?string
    {
        try {
            return $manipulator->build();
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function getManipulator(Value $target): GlideImageManipulator
    {
        if ($target->value() instanceof \Statamic\Assets\Asset) {
            /** @var \Statamic\Assets\Asset $asset */
            $asset = $target->value();
            $path  = $asset->absoluteUrl();
        } else {
            $path = $target->value();
        }

        /** @var GlideImageManipulator $manipulator */
        $manipulator = Image::manipulate(static::normalizeItem($path));

        return $manipulator;
    }

    public static function normalizeItem($item)
    {
        if ($item instanceof AssetContract) {
            return $item;
        }

        // External URLs are already fine as-is.
        if (Str::startsWith($item, ['http://', 'https://'])) {
            return $item;
        }

        // Double colons indicate an asset ID.
        if (Str::contains($item, '::')) {
            return Asset::find($item);
        }

        // In a subfolder installation, the subfolder will likely be passed in
        // with the path. We don't want it in there, so we'll strip it out.
        // We'll need it to have a leading slash to be treated as a URL.
        $item = Str::ensureLeft(Str::removeLeft($item, Config::getSiteUrl()), '/');

        // In order for auto focal cropping to happen, we need to provide an
        // actual asset instance to the manipulator instead of just a URL.
        if ($asset = Asset::find($item)) {
            $item = $asset;
        }

        return $item;
    }
}