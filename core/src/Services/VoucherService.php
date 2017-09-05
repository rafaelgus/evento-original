<?php
namespace EventoOriginal\Core\Services;


use EventoOriginal\Core\Entities\Category;
use EventoOriginal\Core\Entities\Voucher;
use EventoOriginal\Core\Persistence\Repositories\VoucherRepository;
use Exception;

class VoucherService
{
    const STATUS_USED = 'used';
    const STATUS_ACTIVE = 'active';

    const TYPE_RELATIVE = 'relativo';
    const TYPE_ABSOLUTE = 'absoluto';

    private $voucherRepository;

    public function __construct(VoucherRepository $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }

    /**
     * @param string $code
     * @param $value
     * @param string $type
     * @param string $amount
     * @return Voucher
     */
    public function create(string $code, string $type, $value = null, $amount = null, Category $category = null)
    {
        $voucher = new Voucher();
        $voucher->setCode($code);
        $voucher->setStatus(self::STATUS_ACTIVE);
        $voucher->setType($type);

        if (self::TYPE_ABSOLUTE) {
            $voucher->setAmount($amount);
        } elseif (self::TYPE_RELATIVE) {
            $voucher->setValue($value);
        }
        if ($category) {
            $voucher->setCategory($category);
        }
        $this->voucherRepository->save($voucher);

        return $voucher;
    }

    /**
     * @param int $id
     * @return null|Voucher
     */
    public function findById(int $id)
    {
        return $this->voucherRepository->findById($id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->voucherRepository->findAll();
    }

    /**
     * @param string $code
     * @return null|Voucher
     */
    public function findByCode(string $code)
    {
        return $this->voucherRepository->findByCode($code);
    }

    public function save(Voucher $voucher)
    {
        $this->voucherRepository->save($voucher);
    }

    /**
     * @param string $code
     * @throws Exception
     *
     */
    public function useVoucher(string $code)
    {
        $voucher = $this->voucherRepository->findByCode($code);

        if ($voucher) {
            if ($voucher->getStatus() != self::STATUS_USED) {
                $voucher->setStatus(self::STATUS_USED);

                $this->save($voucher);
            } else {
                throw new Exception('this vouchers is already used');
            }
        }
    }

    public function getDiscountAmount(Voucher $voucher, $total)
    {
        if ($voucher->getType() === self::TYPE_ABSOLUTE) {
            $discount = $voucher->getAmount();

            return $discount;
        } elseif ($voucher->getType() === self::TYPE_RELATIVE) {
            $discount = $total * ($voucher->getValue() / 100);

            return $discount;
        } else {
            throw new Exception('Invalid voucher');
        }
    }
}