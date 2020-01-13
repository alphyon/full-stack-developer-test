<?php


namespace App\Http\Controllers;


use App\Account;
use App\Fee;
use App\Http\Repositories\AccountsRepository;
use App\Http\Repositories\FeesRepository;
use App\InOut;
use App\Http\Controllers\Utils\LogManger;
use App\Http\Controllers\Utils\ResponseUtils;
use App\Http\Exceptions\UpdateException;
use App\Http\Repositories\InOutRepository;
use App\Http\Requests\InOutsRequest;
use App\Http\Resources\InOutResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InOutController extends Controller
{
    protected $repo;

    public function __construct()
    {

        $this->repo = new InOutRepository(new InOut());
    }

    public function create(Request $request)
    {
        $data = [
            'account_id' => $request->account_id,
            'temp_license' => $request->temp_license,
            'in' => Carbon::now()->toString(),
            'out' => null,
            'status' => 'active'
        ];


        try {
            $create = $this->repo->create($data);

            throw_if(is_null($create->id), new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('InOut create', $create, 201, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 200, 'No create inOut');
        }


    }

    public function list()
    {
        $inOuts = $this->repo->all();
        try {

            throw_if($inOuts->count() === 0, new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('Data from InOuts', InOutResponse::collection($inOuts), 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 404, $this->NOT_FOUND);
        }

    }

    public function show(Request $request)
    {
        $inOuts = $this->repo->find($request->id);
        try {

            throw_if($inOuts->count() === 0, new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('Data from InOuts', new InOutResponse($inOuts), 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 404, $this->NOT_FOUND);
        }

    }

    public function update(Request $request)
    {
        $id = $request->id;
        $pay = 0;
        $data = [
            'out' => Carbon::now()->toString(),
            'status' => 'close',
        ];


        try {
            $inOut = $this->repo->find($id);
            $update = $inOut->update($data);
            $inOut->syncChanges();

            $minutesIn = new Carbon($inOut->in);
            $minutesOut = new Carbon($inOut->out);
            $this->logManager()->info("IN".$minutesIn."  OUT".$minutesOut);
            $minutes = $minutesOut->diffInMinutes($minutesIn);
            $this->logManager()->info("MINUTES CALCULATE".$minutes);

            if (is_null($inOut->temp_license) && !is_null($inOut->account_id)) {
                $repoA = new AccountsRepository(new Account());
                $accountData = $repoA->find($inOut->account_id);
                $add = $accountData->month_minutes + $minutes;
                $accoutUpdate = $accountData->update(['month_minutes' => $add]);
                $this->logManager()->info('MINUTES UPDATE: ' . $accoutUpdate);
                $this->logManager()->info('CUENTA RESIDENTE');


            }else{
                $repoFee = new FeesRepository(new Fee());
                $repoData = $repoFee->findbyparam('name','NO_RESIDENT')->get();
                $this->logManager()->info($repoData[0]->value);
                $pay = $minutes * $repoData[0]['value'];
                $this->logManager()->info($pay);

                $this->logManager()->info('CUENTA NO RESIDENTE');
            }



            throw_if(!$update, new UpdateException('NOT UPDATE DATA'));
            return $this->responseManage()->response('Update InOut', $pay, 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 422, "Error update");
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;


        try {
            $inOut = $this->repo->find($id);

            $del = $inOut->delete();

            throw_if(!$del, new \Exception('NOT DELETE DATA'));
            return $this->responseManage()->response('Delete InOut', null, 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 422, "Error delete");
        }
    }
}
