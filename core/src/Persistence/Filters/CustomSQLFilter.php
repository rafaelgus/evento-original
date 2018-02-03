<?php
namespace EventoOriginal\Core\Persistence\Filters;

use Doctrine\ORM\Query\Filter\SQLFilter;

abstract class CustomSQLFilter extends SQLFilter
{
    public function getValuesOfArrayParameter($name)
    {
        $arrayParameter = $this->getParameter($name);
        $arrayParameter = substr($arrayParameter, 2, strlen($arrayParameter) - 4);

        return $arrayParameter;
    }
}
