<?php
namespace EventoOriginal\Core\Persistence\Filters;

use Doctrine\ORM\Mapping\ClassMetadata;
use EventoOriginal\Core\Entities\Article;

class ArticleBrandFilter extends CustomSQLFilter
{
    public function addFilterConstraint(ClassMetadata $metadata, $table)
    {
        if ($metadata->getReflectionClass()->name === Article::class) {
            $brands = $this->getValuesOfArrayParameter('brands');

            return "{$table}.brand_id IN ($brands)";
        }

        return "";
    }
}
