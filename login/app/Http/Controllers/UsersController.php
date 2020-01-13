<?php


namespace App\Http\Controllers;


use App\Http\Repositories\UsersRepository;
use App\Http\Requests\UserRequest;
use App\User;

class UsersController extends Controller
{
    public function register(UserRequest $request){
        try {
            $userRepo = new UsersRepository(new User());
            $data = [
                'name' => $request->name,
                'password' => $this->bcrypt($request->password),
                'email' => $request->email,
            ];

            $user = $userRepo->create($data);

            $response['user'] = $user;
            $response['token'] = $user->createToken('APP_LOGIN')->accessToken;

            return $this->responseManage()->response("Create User", $response, 201, null);
        }catch (\Exception $exception){
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 422, 'ERROR TO REGISTER USER');

        }
    }

}
