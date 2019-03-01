<?php

namespace App\Controller\Security;

use App\Controller\BaseController;
use App\Controller\Interfaces\Security\SecurityProfile;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * Class SecurityProfileController
 * Working with user profile
 * @package App\Controller
 */
class SecurityProfileController extends BaseController implements SecurityProfile
{

    /**
     * Change user password
     * @SWG\Tag(
     *      name="Profile"
     * )
     * @SWG\Response(
     *      response=200,
     *      description="User password changed",
     *      @SWG\Schema(
     *          type="object",
     *          example={"success": "ok"},
     *          @SWG\Property(property="success", type="string", description="Password changed")
     *      )
     * )
     * @SWG\Parameter(
     *      name="passwords",
     *      in="body",
     *      required=true,
     *      description="Old and new passwords",
     *      @SWG\Schema(
     *          type="object",
     *          example={"old_password": "old_password", "new_password": "new_password"}
     *      )
     * )
     * @SWG\Response(
     *      response=401,
     *      description="Bad credentials",
     *      @SWG\Schema(
     *          type="object",
     *          example={"code": "code", "message": "message"},
     *          @SWG\Property(property="code", type="integer", description="Http status code"),
     *          @SWG\Property(property="message", type="string", description="Error message")
     *      )
     * )
     * @param Request $request
     * @Rest\Route("/profiles/change-password", methods={"PUT"})
     * @return JsonResponse
     */
    public function putChangePasswordAction(Request $request): JsonResponse
    {
        $preAuthToken = $this->container->get('token_authenticator');
        $token = $preAuthToken->getCredentials($request);
        $user = $preAuthToken->getUser($token);
        $props = json_decode($request->getContent(), true);

        if ($props['old_password'] == $props['new_password']) {
            throw new CustomUserMessageAuthenticationException('Invalid password');
        }

        $encoder = $this->container->get('security.password_encoder');
        $valid = $encoder->isPasswordValid($user, $props['old_password']);

        if (!$valid) {
            throw new CustomUserMessageAuthenticationException('Invalid password');
        }

        $password = $encoder->encodePassword($user, $props['new_password']);
        $user->setPassword($password);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new JsonResponse(array('success' => 'ok'));
    }

    /**
     * Confirm change user email
     * @SWG\Tag(
     *      name="Profile"
     * )
     * @SWG\Parameter(
     *      name="token",
     *      in="path",
     *      required=true,
     *      type="string",
     *      description="Confirmation token",
     * )
     * @SWG\Response(
     *      response=200,
     *      description="E-mail confirmed",
     *      @SWG\Schema(
     *          type="object",
     *          example={"success": "ok"},
     *          @SWG\Property(property="success", type="string", description="E-mail confirmed")
     *      )
     * )
     * @SWG\Response(
     *      response=401,
     *      description="Bad credentials",
     *      @SWG\Schema(
     *          type="object",
     *          example={"code": "code", "message": "message"},
     *          @SWG\Property(property="code", type="integer", description="Http status code"),
     *          @SWG\Property(property="message", type="string", description="Error message")
     *      )
     * )
     * @param $token string
     * @Rest\Route("/profiles/confirm-email-update/{token}", methods={"GET"})
     * @return JsonResponse
     */
    public function getProfilesConfirmEmailUpdateAction($token): JsonResponse
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(array('confirmationToken' => $token));

        if (!$user) {
            throw new CustomUserMessageAuthenticationException('Invalid E-mail token');
        }

        return new JsonResponse(array('success' => true));
    }
}