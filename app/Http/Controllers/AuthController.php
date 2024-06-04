<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Historie;
use App\Models\User;
use App\Traits\ReflactionNameMethod;

class AuthController extends Controller
{
    use ReflactionNameMethod;
    protected $modeficationModel = 'User';
    public function login(Request $request)
    {
        // Валидация входящих данных
        $validator = Validator::make($request->all(), [
            'email'         => 'required|string|email|max:80',
            'pass'          => 'required|string|max:8',
        ]);
        if ($validator->fails()) {return response()->json($validator->errors(), 400);}

        //Выбрали если нашли в базе пользователя
        $user = User::where('email', $request->email)
                    ->where('pass', Hash::make($request->pass))->first();
        //Пишем историю
        if($user->exist()){
            Historie::create([
                'model_id'   => $user->id,
                'model_name' => $this->modeficationModel.' '.$this->getNameMethod(),
                'before'     => json_encode($user->toArray()),
                'after'      => json_encode($user->toArray()),
                'action'     => 'on',
            ]);
        }

        //Вернули ответ
        return ($user->exist()) ? response()->json([
            'token'         => $user->createToken('auth_token')->plainTextToken,
            'type'          => 'Bearer',
        ]) : response()->json($validator->errors(), 400);
    }
    public function register(Request $request)
    {
        // Валидация входящих данных
        $validator = Validator::make($request->all(), [
            'last_name'     => 'required|string|max:40',
            'name'          => 'required|string|max:40',
            'middle_name'   => 'required|string|max:40',
            'email'         => 'required|string|email|max:80|unique:users',
            'pass'          => 'required|string|max:8',
            'phone'         => 'required|string|min:20',

        ]);
        if ($validator->fails()) {return response()->json($validator->errors(), 400);}

        // Создание пользователя
        $user = User::create([
            'last_name'     => $request->last_name,
            'name'          => $request->name,
            'middle_name'   => $request->name,
            'email'         => $request->email,
            'pass'          => Hash::make($request->pass),
            'phone'         => $request->phone,
        ]);

        //Пишем историю
        if($user->exist()){
            Historie::create([
                'model_id'   => $user->id,
                'model_name' => $this->modeficationModel.' '.$this->getNameMethod(),
                'before'     => json_encode([]),
                'after'      => json_encode($user->toArray()),
                'action'     => 'on',
            ]);
        }

        // Ответ с токеном
        return response()->json([
            'token'         => $user->createToken('auth_token')->plainTextToken,
            'type'          => 'Bearer',
        ]);
    }
    public function resetPassword(Request $request)
    {
        // Валидация входящих данных
        $validator = Validator::make($request->all(), [
            'email'         => 'required|string|email|max:80',
        ]);
        if ($validator->fails()) {return response()->json($validator->errors(), 400);}

        //Выбрали если нашли в базе пользователя
        $userBefore = $user = User::where('email', $request->email)->first();

        //Обновили пароль
        if($user->exist()){
            $user->pass = Hash::make($pass = str_random(8));
            $user->save();
        }

        //Пишем историю
        if($userBefore->exist() && $user->exist()){
            Historie::create([
                'model_id'   => $user->id,
                'model_name' => $this->modeficationModel.' '.$this->getNameMethod(),
                'before'     => json_encode($userBefore->toArray()),
                'after'      => json_encode($user->toArray()),
                'action'     => 'on',
            ]);
        }

        //Вернули ответ
        return ($user->exist()) ? response()->json([
            'token'         => $user->createToken('auth_token')->plainTextToken,
            'pass'          => $pass,
            'type'          => 'Bearer',
        ]) : response()->json($validator->errors(), 400);
    }
}
