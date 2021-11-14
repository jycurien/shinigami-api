<?php


namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class TokenController extends AbstractController
{
    /**
     * @Route("/tokens", name="api_login", methods={"POST"})
     * @param Request $request
     * @param UserRepository $userRepository
     * @param UserPasswordHasherInterface $passwordHasher
     * @param JWTEncoderInterface $JWTEncoder
     * @return JsonResponse
     * @throws JWTEncodeFailureException
     */
    public function apiLogin(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, JWTEncoderInterface $JWTEncoder):JsonResponse
    {
        /** @var User $user */
        $user = $userRepository->findOneByUsername($request->getUser());

        if (!$user) {
            throw $this->createNotFoundException();
        }

        $isValid = $passwordHasher->isPasswordValid($user, $request->getPassword());

        if (!$isValid) {
            throw new BadCredentialsException();
        }

        $token = $JWTEncoder->encode([
            'username' => $user->getUserIdentifier(),
            'password' => $request->getPassword(),
            'exp' => time() + 3600
        ]);

        return $this->json(['token' => $token]);
    }
}