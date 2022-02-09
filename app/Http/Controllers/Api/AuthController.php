<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\AccountService;
use App\Services\RoleService;
use App\Services\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\DataPreparation;
use App\Traits\Permission;
use League\Fractal\Resource\Item;



class AuthController extends Controller
{
    use DataPreparation;
    use Permission;

    private UserService $userService;
    private AccountService $accountService;
    private RoleService $roleService;

    public function __construct
    (
        UserService $userService,
        AccountService $accountService,
        RoleService $roleService
    )
    {
        $this->middleware('auth:sanctum', ['except' => ['register', 'login']] );
        $this->middleware('auth.user', ['except' => ['register', 'login']]);
        $this->userService = $userService;
        $this->accountService = $accountService;
        $this->roleService = $roleService;
    }

    // Регистрация нового пользователя и аккаунта к нему
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->all(['email', 'password']);

        try {

            $account = $this->accountService->createAccount('Новый аккаунт');
            $user = $this->userService->createUser($account, $data);
            $this->roleService->assignRoles($user, [Role::ADMIN]);

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true,
        ], 200);
    }

    // Вход в систему
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->only('email', 'password');
        $user = $this->userService->getUserByLogin($data['email']);

        if (!$user || ! Auth::attempt($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        $token = $user->createToken('auth_token', [...$user->permissions, Role::USER ])->plainTextToken;
        $resource = new Item($user, new UserTransformer());

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $this->createData($resource)
        ]);
    }

    // Выход из системы
    public function logout(): \Illuminate\Http\JsonResponse
    {
        try {
            auth()->user()->tokens()->delete();

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true
        ]);
    }

    // Получение текущего пользователя
    public function userProfile(): \Illuminate\Http\JsonResponse
    {
        try {
            $user = auth()->user();
            $resource = new Item($user, new UserTransformer());
        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'user' => $this->createData($resource)
        ]);
    }
}
