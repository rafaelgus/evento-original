<?php
namespace EventoOriginal\Core\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\ProductRepository")
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    protected $name;

    protected $description;

    protected $code;

    protected $barCode;

    protected $weight;
    
    protected $status;

    protected $price;

    protected $currencyPrice;

    protected $publishedOn;
}
