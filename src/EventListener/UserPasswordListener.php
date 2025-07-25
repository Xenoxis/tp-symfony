<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPasswordListener
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function prePersist(object $args): void
    {
        if (!$args instanceof LifecycleEventArgs) {
            return;
        }

        $entity = $args->getObject();

        if (!$entity instanceof User) {
            return;
        }

        $this->encodePassword($entity);
    }

    public function preUpdate(object $args): void
    {
        if (!$args instanceof LifecycleEventArgs) {
            return;
        }

        $entity = $args->getObject();

        if (!$entity instanceof User) {
            return;
        }

        $this->encodePassword($entity);

        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(User::class);
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }


    private function encodePassword(User $user): void
    {
        $plainPassword = $user->getPassword();

        if ($plainPassword && !$this->isPasswordHashed($plainPassword)) {
            $hashed = $this->passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashed);
        }
    }

    private function isPasswordHashed(string $password): bool
    {
        // Exemple basique, à adapter selon ton algo
        return strlen($password) === 60 && preg_match('/^\$2y\$/', $password);
    }
}
