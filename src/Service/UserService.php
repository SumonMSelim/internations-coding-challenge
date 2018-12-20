<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private $userRepository;

    private $encoder;

    private $JWTEncoder;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $encoder, JWTEncoderInterface $JWTEncoder)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
        $this->JWTEncoder = $JWTEncoder;
    }

    public function checkIfUserExists(string $username): ?User
    {
        return $this->userRepository->findOneBy(['username' => $username]);
    }

    public function authenticateUser(User $user, string $password): bool
    {
        return $this->encoder->isPasswordValid($user, $password);
    }

    public function generateToken(string $username)
    {
        try {
            return $this->JWTEncoder->encode([
                'username' => $username,
                'exp' => time() + 3600 // 1 hour expiration
            ]);
        } catch (JWTEncodeFailureException $e) {
            return $e;
        }
    }
}
