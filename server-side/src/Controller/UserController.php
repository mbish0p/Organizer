<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\PasswordHasher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractApiController
{

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function userRegistration(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $email = $request->get('email');
        $name = $request->get('name');
        $username = $request->get('username');
        $surname = $request->get('surname');
        $password = $request->get('password');

        if (!$email || !$password) {
            return $this->respond('No critical crudentials to create user account', Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userRepository->findOneByEmail($email);

        if ($user) {
            return $this->respond('User already exist', Response::HTTP_CONFLICT);
        }

        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword($user, $password);

        $user->setName($name);
        $user->setSurname($surname);
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setPassword($hashedPassword);


        $eu = $this->getDoctrine()->getManager();
        $eu->persist($user);
        $eu->flush($user);

        return $this->respond($user);
    }
}
