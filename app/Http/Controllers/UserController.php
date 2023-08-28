<?php
namespace App\Http\Controllers;
use App\Http\Requests\User\ActivateUserRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\ImportUserExcel;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserSendVerifyEmailRequest;
use App\Models\User;
use App\Responses\ApiResponse;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class UserController extends Controller
{
    /**
     * Index function
     *
     * @param UserService $userService
     * @param ApiResponse $apiResponse
     */
    public function __construct(protected UserService $userService,protected  ApiResponse $apiResponse){}

    /**
     * Undocumented function
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function index(UserRequest $request): JsonResponse
    {
        $accounts = $this->userService->getAll($request->validated());

        return $this->apiResponse
            ->setData($accounts['data'] ?? [])
            ->setMessages($accounts['messages'] ?? [])
            ->setErrors($accounts['errors'] ?? [])
            ->setCode($accounts['code'])
            ->setMeta($accounts['meta'])
            ->create();
    }

    /**
     * unauthorized function
     *
     * @return JsonResponse
     */
    public function unauthorized(): JsonResponse
    {
        return $this->apiResponse
        ->setData([])
        ->setMessages([])
        ->setErrors([__('unauthorized')])
        ->setCode(Response::HTTP_UNAUTHORIZED)
        ->create();
    }

    /**
     * logout function
     *
     * @return JsonResponse
     */
    public function tmpExcelUserImport()
    {
         return $this->userService->tmpExcelUserImport();
    }

      /**
     * logout function
     *
     * @return JsonResponse
     */
    public function importExcelUser(ImportUserExcel $request)
    {
         $response= $this->userService->importExcelUser($request->validated());

         return $this->apiResponse
         ->setData($response['data'])
         ->setMessages($response['messages'])
         ->setErrors($response['errors'])
         ->setCode($response['code'])
         ->create();
    }
    /**
     * login function
     *
     * @param UserLoginRequest $userLoginRequest
     * @return JsonResponse
     */
    public function login(UserLoginRequest $userLoginRequest): JsonResponse
    {
        $response = $this->userService->login($userLoginRequest->validated());
        return $this->apiResponse
            ->setData($response['data'])
            ->setMessages($response['messages'])
            ->setErrors($response['errors'])
            ->setCode($response['code'])
            ->create();
    }
    /**
     * sendVerifyEmail function
     *
     * @param UserSendVerifyEmailRequest $userSendVerifyEmailRequest
     * @return JsonResponse
     */
    public function sendVerifyEmail(UserSendVerifyEmailRequest $userSendVerifyEmailRequest): JsonResponse
    {
        $response = $this->userService->sendVerifyEmail($userSendVerifyEmailRequest->string('email')->trim());

        return $this->apiResponse
            ->setData($response['data'])
            ->setMessages($response['messages'])
            ->setErrors($response['errors'])
            ->setCode($response['code'])
            ->create();
    }

    /**
     * VerifyUserEmail function
     *
     * @param integer $code
     * @param User $user
     * @return JsonResponse
     */
    public function VerifyUserEmail(int $code,User $user): JsonResponse
    {
        $response = $this->userService->verifyUserEmail($user,$code);

        return $this->apiResponse
            ->setData($response['data'])
            ->setMessages($response['messages'])
            ->setErrors($response['errors'])
            ->setCode($response['code'])
            ->create();
    }
    /**
     * getAuthenticatedUser function
     *
     * @return void
     */
    public function getAuthenticatedUser()
    {
        $response = $this->userService->getAuthenticatedUser();

        return $this->apiResponse
            ->setData($response['data'])
            ->setMessages($response['messages'])
            ->setErrors($response['errors'])
            ->setCode($response['code'])
            ->create();
    }


    /**
     * logout function
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = auth()->user();

        $user->tokens()->delete();
        return $this->apiResponse
            ->setMessages([trans('auth.logout_success')])
            ->setCode(JsonResponse::HTTP_OK)
            ->create();
    }

    /**
     * refresh function
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $response = $this->userService->refresh();
        return $this->apiResponse
            ->setData($response['data'])
            ->setMessages($response['messages'])
            ->setErrors($response['errors'])
            ->setCode($response['code'])
            ->create();
    }

    /**
     * register function
     *
     * @param RegisterRequest $registerRequest
     * @return JsonResponse
     */
    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        $response = $this->userService->register($registerRequest->validated());
        return $this->apiResponse
            ->setData($response['data'])
            ->setMessages($response['messages'])
            ->setErrors($response['errors'])
            ->setCode($response['code'])
            ->create();
    }

    /**
     *       Function
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $response = $this->userService->getUserById($id);
        return $this->apiResponse
            ->setData($response['data'])
            ->setMessages($response['messages'])
            ->setErrors($response['errors'])
            ->setCode($response['code'])
            ->create();
    }

    /**
     * Update function
     *
     * @param UpdateRequest $updateRequest
     * @param integer $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $updateRequest, int $id): JsonResponse
    {
        $response = $this->userService->update($id, $updateRequest->validated());
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setCode($response['code'])
            ->create();
    }

    /**
     * ChangePassword function
     *
     * @param ChangePasswordRequest $changePasswordRequest
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $changePasswordRequest): JsonResponse
    {
        $response = $this->userService->changePassword($changePasswordRequest->validated());
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setCode($response['code'])
            ->create();
    }


    /**
     * activateUser function
     *
     * @param ActivateUserRequest $activateUserRequest
     * @return JsonResponse
     */
    public function activateUser(ActivateUserRequest $activateUserRequest): JsonResponse
    {
        $response = $this->userService->activateUser($activateUserRequest->user_id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
    /**
     * Delete function
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $response = $this->userService->delete($id);
        return $this->apiResponse
            ->setData($response['data'] ?? [])
            ->setMessages($response['messages'] ?? [])
            ->setErrors($response['errors'] ?? [])
            ->setCode($response['code'])
            ->create();
    }
}
