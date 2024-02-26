<?php
/* ici je récupère la data qui m'a été envoyé depuis le front, je verifie si la data est bien une instance de
UserDTO et je j'initialise un nouvel utilisateur,
 mettant en place le hashage de sont mot de passe puis ainsi que
  son role qui est définis en tant que ROLE_USER,ensuite j'envoie la data en bdd
*/
namespace App\ApiResource\State;

use App\ApiResource\DTO\UserDTO;
use App\Dto\UserResetPasswordDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreateProcessor implements ProcessorInterface
{
    public function __construct(UserPasswordHasherInterface $userPasswordHasher, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    /**
     * @param UserResetPasswordDto $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {

        if($data instanceof UserDTO){
            $user = new User();
            $user->setRoles(['ROLE_USER']);
            $user->setEmail($data->getEmail());
            $user->setName($data->getName());
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $data->getPassword()
                )
            );
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return $user;
         }

        throw new NotFoundHttpException();
    }
}
