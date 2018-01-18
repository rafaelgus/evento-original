<?php

if (!function_exists('current_user')) {
    function current_user()
    {
        return Auth::user();
    }
}

if (!function_exists('current_user_is_admin')) {
    function current_user_is_admin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('storage_url')) {
    function storage_url()
    {
        return "https://evento-original-s3.s3.us-east-2.amazonaws.com";
    }
}


if (!function_exists('menu_item_url')) {
    function menu_item_url(\EventoOriginal\Core\Entities\MenuItem $menuItem)
    {
        if ($menuItem->getCategory()) {
            return "/" . $menuItem->getCategory()->getName();
        }

        return $menuItem->getUrl();
    }
}

if (!function_exists('default_article_image_path')) {
    function default_article_image_path()
    {
        return "https://s3.us-east-2.amazonaws.com/evento-original-s3/img/product-default.png";

    }
}
