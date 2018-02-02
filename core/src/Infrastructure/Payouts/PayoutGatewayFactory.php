<?php
namespace EventoOriginal\Core\Infrastructure\Payouts;

use EventoOriginal\Core\Infrastructure\Payouts\Interfaces\PayoutGatewayInterface;
use RuntimeException;

class PayoutGatewayFactory
{
    /**
     * Internal storage for all available payout gateways
     *
     * @var array
     */
    private $payoutGateways;

    public function __construct(array $payoutGateways = [])
    {
        $this->payoutGateways = $payoutGateways;
    }

    /**
     * All available payout gateways
     *
     * @return array
     */
    public function all()
    {
        return $this->payoutGateways;
    }

    /**
     * Replace the list of available payout gateways
     *
     * @param array $payoutGateways
     */
    public function replace(array $payoutGateways)
    {
        $this->payoutGateways = $payoutGateways;
    }

    /**
     * Register a new namespaced payout gateway class
     *
     * @param string $class
     */
    public function register($class)
    {
        if (!in_array($class, $this->payoutGateways)) {
            $this->payoutGateways[] = $class;
        }
    }

    /**
     * Create a new payout gateway instance
     *
     * @param string $gateway
     * @throws RuntimeException
     * @return PayoutGatewayInterface
     */
    public function create($gateway)
    {
        $class = config("$gateway.payouts_processor");

        if (!class_exists($class)) {
            throw new RuntimeException("Class '$class' not found");
        }

        return app()->make($class);
    }
}
