<?php

namespace App\Controller\Security;

use App\Controller\BaseController;
use App\Controller\Interfaces\Security\SecurityRegister;
use App\Entity\User;
use App\Utils\HttpCode;
use App\Utils\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

/**
 * Class SecurityRegisterController
 * Registration
 * @package App\Controller
 */
class SecurityRegisterController extends BaseController implements SecurityRegister
{

    const REQUIRE_FIELD = [
        'username',
        'password',
        'email'
    ];


    /**
     * Register new user
     * @SWG\Tag(
     *      name="Register"
     * )
     * @SWG\Parameter(
     *      name="body",
     *      in="body",
     *      required=true,
     *      description="Registration data",
     *      @SWG\Schema(
     *          type="object",
     *          example={
     *              "username": "username",
     *              "email": "email",
     *              "password": "password"
     *          }
     *      )
     * )
     * @SWG\Response(
     *      response=200,
     *      description="User registered",
     *      @SWG\Schema(
     *          type="object",
     *          example={"code": "200", "message": "success"},
     *          @SWG\Property(property="success", type="string", description="User registered")
     *      )
     * )
     * @SWG\Response(
     *      response=400,
     *      description="'Required property', 'Invalid username', 'Invalid e-mail'",
     *      @SWG\Schema(
     *          type="object",
     *          example={"code": "400", "message": "errors"},
     *          @SWG\Property(property="code", type="integer", description="Http status code"),
     *          @SWG\Property(property="errors", type="string", description="Error message")
     *      )
     * )
     * @Rest\Route("/register", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function postRegisterAction(Request $request): JsonResponse
    {
        $emailCheckJsonResponse = $this->getRegisterCheckEmailAction($request);

        if ($emailCheckJsonResponse->getStatusCode() !== HttpCode::OK) {
            return $emailCheckJsonResponse;
        }
        $data = $this->getDataFromRequest($request);
        $validator = $this->container->get('app_validator');

        $user = new User();
        $user->setEmail( $data->email);
        $user->setUsername( $data->email);

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $data->password);
        $user->setPassword($password);

        $errors = $validator->toArray($user);

        if ($errors) {
            return Response::toJson(HttpCode::BAD_REQUEST, $errors);
        }

        $tokenGenerator = $this->container->get('token_generator');

        if (!$user->isEnabled()) {
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        } catch (\Exception $exception) {
            return $this->jsonResponse(HttpCode::INTERNAL_SERVER_ERROR, $exception->getMessage());
        }

        return $this->jsonResponse(HttpCode::OK);
    }


    /**
     * Check user email before registration
     * @SWG\Tag(
     *      name="Register"
     * )
     * @SWG\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      description="E-mail for checking",
     *      type="string"
     * )
     * @SWG\Response(
     *      response=200,
     *      description="User e-mail is valid",
     *      @SWG\Schema(
     *          type="object",
     *          example={"success": "ok"},
     *          @SWG\Property(property="success", type="string", description="User e-mail is valid")
     *      )
     * )
     * @SWG\Response(
     *      response=400,
     *      description="'E-mail required', 'Invalid e-mail format'",
     *      @SWG\Schema(
     *          type="object",
     *          example={"code": "code", "message": "message"},
     *          @SWG\Property(property="code", type="integer", description="Http status code"),
     *          @SWG\Property(property="message", type="string", description="Error message")
     *      )
     * )
     * @SWG\Response(
     *      response=409,
     *      description="E-mail exists",
     *      @SWG\Schema(
     *          type="object",
     *          example={"code": "code", "message": "message"},
     *          @SWG\Property(property="code", type="integer", description="Http status code"),
     *          @SWG\Property(property="message", type="string", description="Error message")
     *      )
     * )
     * @Rest\Route("/register/check-email", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getRegisterCheckEmailAction(Request $request): JsonResponse
    {
        $email = $this->getDataFromRequest($request)->email;

        if (!$email) {
            return $this->jsonResponse(HttpCode::BAD_REQUEST, 'E-mail required');
        }

        $emailConstraint = new EmailConstraint();
        $emailConstraint->message = $email;
        $validator = $this->container->get('validator');
        $errorCount = count($validator->validate($email, $emailConstraint));

        if ($errorCount != 0) {
            return $this->jsonResponse(HttpCode::BAD_REQUEST, 'Invalid e-mail format');
        }

        try {
            $user = $this->getDoctrine()->getRepository(User::class);
        } catch (\Exception $exception) {
            return $this->jsonResponse(HttpCode::INTERNAL_SERVER_ERROR, $exception->getMessage());
        }

        if ($user->findOneBy(array('email' => $email))) {
            return $this->jsonResponse(HttpCode::CONFLICT, 'E-mail exists already');
        }

        return $this->jsonResponse(HttpCode::OK);
    }

    /**
     * Check user name before registration
     * @SWG\Tag(
     *      name="Register"
     * )
     * @SWG\Parameter(
     *      name="username",
     *      in="query",
     *      required=true,
     *      description="Username for checking",
     *      type="string"
     * )
     * @SWG\Response(
     *      response=200,
     *      description="Username is valid",
     *      @SWG\Schema(
     *          type="object",
     *          example={"success": "ok"},
     *          @SWG\Property(property="success", type="string", description="User name is not registered")
     *      )
     * )
     * @SWG\Response(
     *      response=400,
     *      description="Username required",
     *      @SWG\Schema(
     *          type="object",
     *          example={"code": "code", "message": "message"},
     *          @SWG\Property(property="code", type="integer", description="Http status code"),
     *          @SWG\Property(property="message", type="string", description="Error message")
     *      )
     * )
     * @SWG\Response(
     *      response=409,
     *      description="Username exists",
     *      @SWG\Schema(
     *          type="object",
     *          example={"code": "code", "message": "message"},
     *          @SWG\Property(property="code", type="integer", description="Http status code"),
     *          @SWG\Property(property="message", type="string", description="Error message")
     *      )
     * )
     * @Rest\Route("/register/check-username", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getRegisterCheckUsernameAction(Request $request): JsonResponse
    {
        $username = $this->getDataFromRequest($request)->username;

        if (!$username) {
            $this->jsonResponse(HttpCode::BAD_REQUEST, 'Username required');
        }

        $repo = $this->getDoctrine()->getRepository(User::class);

        if ($repo->findOneBy(array('username' => $username))) {
            $this->jsonResponse(HttpCode::CONFLICT, 'Username has been already taken');
        }

        return $this->jsonResponse(HttpCode::OK);
    }

    /**
     * Confirm user registration
     * @SWG\Tag(
     *      name="Register"
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
     * @Rest\Route("/register/confirm/{token}", methods={"GET"})
     * @param string $token
     * @return JsonResponse
     */
    public function getRegisterConfirmAction(string $token): JsonResponse
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(array('confirmationToken' => $token));

        if (!$user) {
            return $this->jsonResponse(HttpCode::BAD_REQUEST, 'Invalid E-mail token');
        }

        if (!$user->isEnabled()) {
            $user->setConfirmationToken(NULL);
            $user->setEnabled(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->jsonResponse(HttpCode::OK, 'User is enabled');
    }

    /**
     * Check user is confirmed
     * @SWG\Tag(
     *      name="Register"
     * )
     * @SWG\Response(
     *      response=200,
     *      description="Registration is confirmed",
     *      @SWG\Schema(
     *          type="object",
     *          example={"confirmed": "confirmed"},
     *          @SWG\Property(property="success", type="string", description="Checking success"),
     *          @SWG\Property(property="confirmed", type="string", description="Registration is confirmed")
     *      )
     * )
     * @Rest\Route("/register/confirmed", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getRegisterConfirmedAction(Request $request): JsonResponse
    {
        $data = $this->getDataFromRequest($request);

        if (!$data || !isset($data->username) || !$data->username) {
            return $this->jsonResponse(HTTPCode::OK, ['confirmed' => true]);
        }

        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy(array('username' => $data->username));

        if (!$user) {
            return $this->jsonResponse(HTTPCode::OK, ['confirmed' => true]);
        }

        return $this->jsonResponse(HTTPCode::OK, [
            'confirmed' => $user->getConfirmationToken() ? false : true
        ]);

    }
}
