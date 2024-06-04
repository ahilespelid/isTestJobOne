<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\ReflactionNameMethod;
use App\Models\Historie;
use App\Models\User;

class UserController extends Controller
{
    use ReflactionNameMethod;
    public function index(Request $request, User $users)
    {
        return (1 <> $request->html ?? 0) ? response()->json([
            'users' => $users->all()->toArray()
        ]) : view('listUsers', [
            'users' => $users->all()->toArray(),
            'order' => (('asc' == ($request->order ?? 'desc')) ? 'desc' : 'asc')
        ]);
    }

    public function show(Request $request)
    {
        //Выбрали если нашли в базе пользователя
        $user = User::where('id', $user)->first();

        //Ответ
        return ($user->exist()) ? response()->json([
            'users' => [$user->toArray()]
        ]) : response()->json($validator->errors(), 400);
    }

    public function update(Request $request)
    {
        // Валидация входящих данных
        $validator = Validator::make($request->all(), [
            'last_name'     => 'string|max:40',
            'name'          => 'string|max:40',
            'middle_name'   => 'string|max:40',
            'email'         => 'string|email|max:80|unique:users',
            'pass'          => 'string|max:8',
            'phone'         => 'string|min:20',
        ]);
        if ($validator->fails()) {return response()->json($validator->errors(), 400);}

        //Выбрали если нашли в базе пользователя
        $userBefore = $user = User::where('id', $user)->first();

        //Обновляем модель
        if($user->exist()){
            foreach($request as $fieldUser => $updateUserValue){
                $user->{$fieldUser} = $updateUserValue;
            }$user->save();

        //Пишем историю
            Historie::create([
                'model_id'   => $user->id,
                'model_name' => $this->modeficationModel.' '.$this->getNameMethod(),
                'before'     => json_encode($userBefore->toArray()),
                'after'      => json_encode($user->toArray()),
                'action'     => 'on',
            ]);
        }

        //Ответ
        return ($user->exist()) ? response()->json([
            'users' => [$user->toArray()]
        ]) : response()->json($validator->errors(), 400);
    }

    public function delete(Request $request)
    {
        //Выбрали если нашли в базе пользователя
        $user = User::where('id', $user)->first();

        //Обновляем модель
        if($user->exist()){
            $user->delete();

        //Пишем историю
            Historie::create([
                'model_id'   => $user->id,
                'model_name' => $this->modeficationModel.' '.$this->getNameMethod(),
                'before'     => json_encode([]),
                'after'      => json_encode($user->toArray()),
                'action'     => 'on',
            ]);
        }

        //Ответ
        return ($user->exist()) ? response()->json([
            'users' => [$user->toArray()]
        ]) : response()->json($validator->errors(), 400);
    }



    public function showBasket(Request $request)
    {
        //
    }
    public function restore(Request $request)
    {
        //
    }
    public function destroy(Request $request)
    {
        //
    }


    public function groupDelete(Request $request)
    {
        //
    }
    public function groupDestroy(Request $request)
    {
        //
    }
    public function groupRestore(Request $request)
    {
        //
    }
}
