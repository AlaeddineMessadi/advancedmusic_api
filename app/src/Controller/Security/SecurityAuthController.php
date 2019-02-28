<?php

namespace App\Controller\Security;

use App\Controller\BaseController;
use App\Controller\Interfaces\Security\SecurityAuth;
use App\Entity\InvalidToken;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SecurityAuthController
 *
 * @package App\Controller
 */
class SecurityAuthController extends BaseController implements SecurityAuth
{
    /**
     * Login user
     * @SWG\Tag(
     *     name="Authentication"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Credentials object",
     *     required=true,
     *     @SWG\Schema(
     *         example={"username":"username", "password":"password"}
     *     )
     * )
     * @SWG\Response(
     *     response="200",
     *     description="JSON Web Token for user",
     *     @SWG\Schema(
     *          type="object",
     *          example={"token": "_json_web_token_"},
     *          @SWG\Property(property="token", type="string", description="Json Web Token"),
     *     )
     * )
     * @SWG\Response(
     *      response=400,
     *      description="Bad Request",
     *      @SWG\Schema(
     *          type="object",
     *          example={"code": 400, "message": "Bad Request"},
     *          @SWG\Property(property="code", type="integer", description="Http status code"),
     *          @SWG\Property(property="message", type="string", description="Error message"),
     *      )
     * )
     * @SWG\Response(
     *      response=401,
     *      description="Unauthorized",
     *      @SWG\Schema(
     *          type="object",
     *          example={"code": 401, "message": "Bad credentials"},
     *          @SWG\Property(property="code", type="integer", description="Http status code"),
     *          @SWG\Property(property="message", type="string", description="Error message"),
     *      )
     * )
     * @Rest\Route("/login", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function postLoginAction(Request $request): JsonResponse {
        return  new JsonResponse(array('success' => 'ok'));
    }

    /**
     * Logout user
     * @SWG\Tag(
     *     name="Authentication"
     * )
     * @SWG\Response(
     *     response="200",
     *     description="Reset lifetime JWT token",
     *     @SWG\Schema(
     *          type="object",
     *          example={"success": "ok"},
     *          @SWG\Property(property="token", type="object", description="Try reset lifetime JWT token"),
     *     )
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
     * @Rest\Route("/logout", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function getLogoutAction(Request $request): JsonResponse
    {
        $preAuthToken = $this->container->get('token_authenticator');
        $token = $preAuthToken->getCredentials($request);
        $expiration = $preAuthToken->getExpiration($token);
        $tokenRepo = $this->getDoctrine()->getRepository(InvalidToken::class);
        $now = (new \DateTime())->getTimestamp();

        if (!$tokenRepo->hasActualToken($token, $now))
        {
            $invalidToken = new InvalidToken();
            $invalidToken->setExpiration($expiration);
            $invalidToken->setHash($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($invalidToken);
            $em->flush();
        }

        return new JsonResponse(array('success' => 'ok'));
    }


}
