<?php
namespace EventoOriginal\Core\Persistence\Repositories;

class RoleRepository extends BaseRepository
{
    public function findOneByName(string $name)
    {
        return $this->findOneBy(['name' => $name]);
    }
}
