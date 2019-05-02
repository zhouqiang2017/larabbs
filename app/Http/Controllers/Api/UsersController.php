<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests\Api\UserRequest;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller {
    public function store(UserRequest $request)
    {
        $verifyData = Cache::get($request->verification_key);

        if ( !$verifyData) {
            return $this->response->error('验证码已失效', 422);
        }

        if ( !hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            return $this->response->errorUnauthorized('验证码错误');
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
        ]);

        // 清除验证码缓存
        Cache::forget($request->verification_key);

        return $this->response->created();
        $accessToken = '21__9nfEX21x0x2eY4LOXzL72_OD0-5K4GUnR2eWT2I_lFMoVOh3mOH6ZM34ORPSrZBXwjjH62g6uj8YlCnPm930w';
        $openID = 'oqnAR1AMPjf-9CwNVHN4FnSYWtYQ';
    }
}
