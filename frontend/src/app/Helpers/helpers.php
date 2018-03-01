<?php

if (!function_exists('current_user')) {
    function current_user()
    {
        return Auth::user();
    }
}

if (!function_exists('current_customer')) {
    function current_customer()
    {
        return Auth::user()->getCustomer();
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

if (!function_exists('article_image_url')) {
    function article_image_url(string $filename)
    {
        return storage_url() . "/images/" . $filename;
    }
}


if (!function_exists('storage_url')) {
    function storage_url()
    {
        return env('AWS_S3_URL');
    }
}

if (!function_exists('default_article_image_path')) {
    function default_article_image_path()
    {
        return "https://s3.us-east-2.amazonaws.com/evento-original-s3/img/product-default.png";
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

if (!function_exists('get_circular_design_variant_detail')) {
    function get_circular_design_variant_detail(int $id)
    {
        $repo = app()->make(
            \EventoOriginal\Core\Persistence\Repositories\CircularDesignVariantDetailRepository::class
        );

        return $repo->findOneById($id);
    }
}

if (!function_exists('get_article_design')) {
    function get_article_design_by_barcode(string $barCode)
    {
        $repo = app()->make(
            \EventoOriginal\Core\Persistence\Repositories\ArticleRepository::class
        );

        $article = $repo->findOneByBarCode($barCode);

        if ($article) {
            return $article->getDesign();
        }

        return null;
    }
}
