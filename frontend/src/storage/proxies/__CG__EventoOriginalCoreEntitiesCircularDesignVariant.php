<?php

namespace DoctrineProxies\__CG__\EventoOriginal\Core\Entities;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class CircularDesignVariant extends \EventoOriginal\Core\Entities\CircularDesignVariant implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'id', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'name', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'designMaterialSize', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'numberOfCircles', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'diameterOfCircles', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'previewImage', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'details', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'price'];
        }

        return ['__isInitialized__', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'id', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'name', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'designMaterialSize', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'numberOfCircles', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'diameterOfCircles', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'previewImage', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'details', '' . "\0" . 'EventoOriginal\\Core\\Entities\\CircularDesignVariant' . "\0" . 'price'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (CircularDesignVariant $proxy) {
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
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', []);

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', [$name]);

        parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getDesignMaterialSize()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDesignMaterialSize', []);

        return parent::getDesignMaterialSize();
    }

    /**
     * {@inheritDoc}
     */
    public function setDesignMaterialSize($designMaterialSize): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDesignMaterialSize', [$designMaterialSize]);

        parent::setDesignMaterialSize($designMaterialSize);
    }

    /**
     * {@inheritDoc}
     */
    public function getNumberOfCircles()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNumberOfCircles', []);

        return parent::getNumberOfCircles();
    }

    /**
     * {@inheritDoc}
     */
    public function setNumberOfCircles($numberOfCircles): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNumberOfCircles', [$numberOfCircles]);

        parent::setNumberOfCircles($numberOfCircles);
    }

    /**
     * {@inheritDoc}
     */
    public function getDiameterOfCircles()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDiameterOfCircles', []);

        return parent::getDiameterOfCircles();
    }

    /**
     * {@inheritDoc}
     */
    public function setDiameterOfCircles($diameterOfCircles): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDiameterOfCircles', [$diameterOfCircles]);

        parent::setDiameterOfCircles($diameterOfCircles);
    }

    /**
     * {@inheritDoc}
     */
    public function getPreviewImage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPreviewImage', []);

        return parent::getPreviewImage();
    }

    /**
     * {@inheritDoc}
     */
    public function setPreviewImage($previewImage): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPreviewImage', [$previewImage]);

        parent::setPreviewImage($previewImage);
    }

    /**
     * {@inheritDoc}
     */
    public function getDetails()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDetails', []);

        return parent::getDetails();
    }

    /**
     * {@inheritDoc}
     */
    public function setDetails($details): void
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDetails', [$details]);

        parent::setDetails($details);
    }

    /**
     * {@inheritDoc}
     */
    public function addDetail(\EventoOriginal\Core\Entities\CircularDesignVariantDetail $circularDesignVariantDetail)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addDetail', [$circularDesignVariantDetail]);

        return parent::addDetail($circularDesignVariantDetail);
    }

    /**
     * {@inheritDoc}
     */
    public function getPrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrice', []);

        return parent::getPrice();
    }

    /**
     * {@inheritDoc}
     */
    public function setPrice(int $price)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPrice', [$price]);

        return parent::setPrice($price);
    }

    /**
     * {@inheritDoc}
     */
    public function getMoney()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMoney', []);

        return parent::getMoney();
    }

}
