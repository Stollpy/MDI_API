<?php

namespace App\DataPersister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserPersister implements DataPersisterInterface {

    private $manager;
    private $encoder;

    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $this->manager = $manager;
        $this->encoder = $encoder;
    }

    public function supports($data): bool 
    {
        return $data instanceof User;
    }

    public function persist($data){
        if($data->getPassword()){
            $data->setPassword($this->encoder->encodePassword($data, $data->getPassword()));
            $data->eraseCredentials();
        }
        $this->manager->persist($data);
        $this->manager->flush();        
    }

    public function remove($data){
        $this->manager->remove($data);
        $this->manager->flush();
    }
}