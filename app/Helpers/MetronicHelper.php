<?php

if (!function_exists('getIcon')) {
    function getIcon($icon, $class = '', $tag = 'i')
    {
        return '<' . $tag . ' class="ki-duotone ki-' . $icon . ' ' . $class . '"><span class="path1"></span><span class="path2"></span></' . $tag . '>';
    }
}

if (!function_exists('image')) {
    function image($path)
    {
        return asset('assets/media/' . $path);
    }
}
