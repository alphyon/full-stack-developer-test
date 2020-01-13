<?php


namespace App\Http\Controllers;


use App\Fee;
use App\Http\Controllers\Utils\LogManger;
use App\Http\Controllers\Utils\ResponseUtils;
use App\Http\Exceptions\UpdateException;
use App\Http\Repositories\FeesRepository;
use App\Http\Requests\FeesRequest;
use App\Http\Resources\FeeResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FeesController extends Controller
{
    protected $repo;

    public function __construct()
    {

        $this->repo = new FeesRepository(new Fee());
    }

    public function create(Request $request)
    {
        $data = [
            'name'=>$request->name,
            'type_park'=>$request->type_park,
            'value'=>$request->value,
        ];


        try {
            $create = $this->repo->create($data);

            throw_if(is_null($create->id), new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('Fee create', $create, 201, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 200, 'No create fee');
        }


    }

    public function list()
    {
        $fees = $this->repo->all();
        try {

            throw_if($fees->count() === 0, new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('Data from Fees', FeeResponse::collection($fees), 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 404, $this->NOT_FOUND);
        }

    }

    public function show(Request $request)
    {
        $fees = $this->repo->find($request->id);
        try {

            throw_if($fees->count() === 0, new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('Data from Fees', new FeeResponse($fees), 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 404, $this->NOT_FOUND);
        }

    }

    public function update(Request $request){
        $id = $request->id;
        $data = [
            'name'=>$request->name,
            'type_park'=>$request->type_park,
            'value'=>$request->value,
        ];


        try {
                $fee = $this->repo->find($id);
                $update = $fee->update($data);
                $fee->syncChanges();

            throw_if(!$update , new UpdateException('NOT UPDATE DATA'));
            return $this->responseManage()->response('Update Fee', $fee, 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 402, "Error update");
        }
    }

    public function delete(Request $request){
        $id = $request->id;


        try {
            $fee = $this->repo->find($id);

            $del = $fee->delete();

            throw_if(!$del , new \Exception('NOT DELETE DATA'));
            return $this->responseManage()->response('Delete Fee', null, 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 402, "Error delete");
        }
    }
}
