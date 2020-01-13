<?php


namespace App\Http\Controllers;


use App\Account;
use App\Http\Controllers\Utils\LogManger;
use App\Http\Controllers\Utils\ResponseUtils;
use App\Http\Exceptions\UpdateException;
use App\Http\Repositories\AccountsRepository;
use App\Http\Requests\AccountsRequest;
use App\Http\Resources\AccountResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccountsController extends Controller
{
    protected $repo;

    public function __construct()
    {

        $this->repo = new AccountsRepository(new Account());
    }

    public function create(AccountsRequest $request)
    {
        $data = [
            'car_license'=>$request->car_license,
            'fee_id'=>$request->fee_id,
            'month_minutes'=>0,
        ];


        try {
            $create = $this->repo->create($data);

            throw_if(is_null($create->id), new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('Account create', $create, 201, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 200, 'No create account');
        }


    }

    public function list()
    {
        $accounts = $this->repo->all();
        try {

            throw_if($accounts->count() === 0, new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('Data from Accounts', AccountResponse::collection($accounts), 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 404, $this->NOT_FOUND);
        }

    }

    public function show(Request $request)
    {
        $accounts = $this->repo->find($request->id);
        try {

            throw_if($accounts->count() === 0, new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('Data from Accounts', new AccountResponse($accounts), 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 404, $this->NOT_FOUND);
        }

    }

    public function update(Request $request){
        $id = $request->id;
        $data = [
            'car_license'=>$request->car_license,
            'fee_id'=>$request->fee_id,
            'month_minutes'=>$request->minutes,
        ];

        try {
                $account = $this->repo->find($id);
                $update = $account->update($data);
                $account->syncChanges();

            throw_if(!$update , new UpdateException('NOT UPDATE DATA'));
            return $this->responseManage()->response('Update Account', $account, 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 402, "Error update");
        }
    }

    public function delete(Request $request){
        $id = $request->id;


        try {
            $account = $this->repo->find($id);

            $del = $account->delete();

            throw_if(!$del , new \Exception('NOT DELETE DATA'));
            return $this->responseManage()->response('Delete Account', null, 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 402, "Error delete");
        }
    }
}
