<?php
/**
 * Load JavaScript file.
 */
namespace Plugin\Sitemap;

class Event
{
    public static function ipBeforeController()
    {
        ipAddCss('assets/sitemap.css');
    }

}
