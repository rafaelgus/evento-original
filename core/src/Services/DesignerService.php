<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Designer;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Persistence\Repositories\DesignerRepository;

class DesignerService
{
    private $designerRepository;

    public function __construct(
        DesignerRepository $designerRepository
    ) {
        $this->designerRepository = $designerRepository;
    }

    public function create(User $user, string $nickname)
    {
        $designer = new Designer();
        $designer->setUser($user);
        $designer->setNickname($nickname);

        $this->designerRepository->save($designer);

        return $designer;
    }
}
