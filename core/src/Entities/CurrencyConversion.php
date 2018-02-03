<?php
namespace EventoOriginal\Core\Entities;

use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\CurrencyConversionRepository")
 * @ORM\Table(name="currency_conversions")
 */
class CurrencyConversion
{
    const CURRENCY_USD = 'USD';
    const CURRENCY_EUR = 'EUR';

    public static $allowedCurrencies = [self::CURRENCY_EUR, self::CURRENCY_USD];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $fromCurrency;

    /**
     * @ORM\Column(type="string")
     */
    private $toCurrency;

    /**
     * @ORM\Column(type="decimal")
     */
    private $rate;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFromCurrency(): string
    {
        return $this->fromCurrency;
    }

    /**
     * @param string $fromCurrency
     */
    public function setFromCurrency(string $fromCurrency)
    {
        if (!in_array($fromCurrency, static::$allowedCurrencies)) {
            throw new InvalidArgumentException('Not allowed currency');
        }

        $this->fromCurrency = $fromCurrency;
    }

    /**
     * @return string
     */
    public function getToCurrency(): string
    {
        return $this->toCurrency;
    }

    /**
     * @param string $toCurrency
     */
    public function setToCurrency(string $toCurrency)
    {
        if (!in_array($toCurrency, static::$allowedCurrencies)) {
            throw new InvalidArgumentException('Not allowed currency');
        }

        $this->toCurrency = $toCurrency;
    }

    /**
     * @return mixed
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param mixed $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }
}
