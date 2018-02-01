<?php

namespace DoctrineProxies\__CG__\EventoOriginal\Core\Entities;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Order extends \EventoOriginal\Core\Entities\Order implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'id', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'createDate', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'ordersDetail', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'payment', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'user', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'status', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'referralVisitorEvent', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'billing', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'shipping'];
        }

        return ['__isInitialized__', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'id', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'createDate', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'ordersDetail', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'payment', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'user', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'status', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'referralVisitorEvent', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'billing', '' . "\0" . 'EventoOriginal\\Core\\Entities\\Order' . "\0" . 'shipping'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Order $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreateDate', []);

        return parent::getCreateDate();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreateDate(\DateTime $date)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreateDate', [$date]);

        return parent::setCreateDate($date);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrdersDetail()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOrdersDetail', []);

        return parent::getOrdersDetail();
    }

    /**
     * {@inheritDoc}
     */
    public function setOrdersDetail(array $ordersDetail)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOrdersDetail', [$ordersDetail]);

        return parent::setOrdersDetail($ordersDetail);
    }

    /**
     * {@inheritDoc}
     */
    public function getPayment()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPayment', []);

        return parent::getPayment();
    }

    /**
     * {@inheritDoc}
     */
    public function setPayment(\EventoOriginal\Core\Entities\Payment $payment)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPayment', [$payment]);

        return parent::setPayment($payment);
    }

    /**
     * {@inheritDoc}
     */
    public function getUser()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUser', []);

        return parent::getUser();
    }

    /**
     * {@inheritDoc}
     */
    public function setUser(\EventoOriginal\Core\Entities\User $user)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUser', [$user]);

        return parent::setUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function getTotal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTotal', []);

        return parent::getTotal();
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', []);

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus(string $status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', [$status]);

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function addOrderDetail(\EventoOriginal\Core\Entities\OrderDetail $orderDetail)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addOrderDetail', [$orderDetail]);

        return parent::addOrderDetail($orderDetail);
    }

    /**
     * {@inheritDoc}
     */
    public function getReferralVisitorEvent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReferralVisitorEvent', []);

        return parent::getReferralVisitorEvent();
    }

    /**
     * {@inheritDoc}
     */
    public function setReferralVisitorEvent(\EventoOriginal\Core\Entities\VisitorEvent $referralVisitorEvent)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setReferralVisitorEvent', [$referralVisitorEvent]);

        return parent::setReferralVisitorEvent($referralVisitorEvent);
    }

    /**
     * {@inheritDoc}
     */
    public function getBilling()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBilling', []);

        return parent::getBilling();
    }

    /**
     * {@inheritDoc}
     */
    public function setBilling(\EventoOriginal\Core\Entities\Billing $billing)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBilling', [$billing]);

        return parent::setBilling($billing);
    }

    /**
     * {@inheritDoc}
     */
    public function getShipping()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getShipping', []);

        return parent::getShipping();
    }

    /**
     * {@inheritDoc}
     */
    public function setShipping(\EventoOriginal\Core\Entities\Shipping $shipping)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setShipping', [$shipping]);

        return parent::setShipping($shipping);
    }

}
