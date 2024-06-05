<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Traits\ReflactionNameMethod;
use App\Services\HistorieManager;
use App\Models\User;

class UserController extends Controller
{
    use ReflactionNameMethod;
    public function index(Request $request, User $users)
    {
        //Используем редис для кеша
        $usersAt = ($isEmptyCache = empty($usersCache = Cache::get('usersAll')) ?
                        $users->all()->toArray() :
                        $usersCache);

        // Кэширование значения
        if($isEmptyCache){
            Cache::put('usersAll', $usersAt, 600);
        }

        return (1 <> $request->html ?? 0) ? response()->json([
            'users' => $usersAt
        ]) : view('listUsers', [
            'users' => $usersAt,
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
        if($user->exist() && $userBefore->exist()){
            foreach($request as $fieldUser => $updateUserValue){
                $user->{$fieldUser} = $updateUserValue;
            }$user->save();

        //Пишем историю
            HistorieManager->logAdd($user->id,
                                    $this->modeficationModel.' '.$this->getNameMethod(),
                                    json_encode($userBefore->toArray()),
                                    json_encode($user->toArray()));
        }

        //Ответ
        return ($user->exist()) ? response()->json([
            'users' => [$user->toArray()]
        ]) : response()->json($validator->errors(), 400);
    }
    public function delete(Request $request)
    {
        //Выбрали если нашли в базе пользователя
        $userAt = User::where('id', $user)->first();

        //Обновляем модель
        if($userAt->exist()){
            $userAt->delete();

            HistorieManager->logAdd($userAt->id,
                                    $this->modeficationModel.' '.$this->getNameMethod(),
                                    json_encode([]),
                                    json_encode($userAt->toArray()));
        }

        //Ответ
        return ($userAt->exist()) ? response()->json([
            'user' => [$userAt->toArray()]
        ]) : response()->json($validator->errors(), 400);
    }


    public function showBasket()
    {
        //Выбрали удалённых пользователей
        $users = User::onlyTrashed()->get();
        //Ответ
        return ($users->exist()) ? response()->json([
            'users' => $users->toArray()
        ]) : response()->json($validator->errors(), 400);

    }
    public function restore(Request $request)
    {
        //Выбрали если нашли в базе пользователя
        $userAtBefore = $userAt = User::where('id', $user)->first();

        //Востанавливаем модель
        if($userAt->exist() && $userAtBefore->exist()){
            $userAt->restore();

            HistorieManager->logAdd($userAt->id,
                                    $this->modeficationModel.' '.$this->getNameMethod(),
                                    json_encode($userAtBefore->toArray()),
                                    json_encode($userAt->toArray()));
        }

        //Ответ
        return ($userAt->exist()) ? response()->json([
            'user' => [$userAt->toArray()]
        ]) : response()->json($validator->errors(), 400);
    }
    public function destroy(Request $request)
    {
        //Выбрали если нашли в базе пользователя
        $userAt = User::where('id', $user)->first();

        //Востанавливаем модель
        if($userAt->exist()){
            $userAt->forceDelete();

            HistorieManager->logAdd($userAt->id,
                                    $this->modeficationModel.' '.$this->getNameMethod(),
                                    json_encode($userAt->toArray()),
                                    json_encode([]));
        }

        //Ответ
        return ($userAt->exist()) ? response()->json([
            'user' => []
        ]) : response()->json($validator->errors(), 400);
    }


    public function groupDelete(User $users)
    {
        $users->all()->delete();
        return response()->json(['status' => 'ok']);
    }
    public function groupDestroy(User $users)
    {
        $users->all()->forceDelete();
        return response()->json(['status' => 'ok']);
    }
    public function groupRestore(User $users)
    {
        $users->onlyTrashed()->get()->restore();
        return response()->json(['status' => 'ok']);
    }
}
