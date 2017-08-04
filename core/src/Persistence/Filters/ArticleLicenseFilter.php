<?php
namespace EventoOriginal\Core\Persistence\Filters;

use Doctrine\ORM\Mapping\ClassMetadata;
use EventoOriginal\Core\Entities\Article;

class ArticleLicenseFilter extends CustomSQLFilter
{
    /**
     * Gets the SQL query part to add to a query.
     *
     * @param ClassMetaData $metadata
     * @param string $table
     *
     * @return string The constraint SQL if there is available, empty string otherwise.
     */
    public function addFilterConstraint(ClassMetadata $metadata, $table)
    {
        if ($metadata->getReflectionClass()->name === Article::class) {
            $licenses = $this->getValuesOfArrayParameter('licenses');

            return "{$table}.license_id IN ($licenses)";
        }

        return "";
    }
}
