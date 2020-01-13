<?php


namespace App\Http\Controllers;


use App\Car;
use App\Http\Controllers\Utils\LogManger;
use App\Http\Controllers\Utils\ResponseUtils;
use App\Http\Exceptions\UpdateException;
use App\Http\Repositories\CarsRepository;
use App\Http\Requests\CarsRequest;
use App\Http\Resources\CarResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarsController extends Controller
{
    protected $repo;

    public function __construct()
    {

        $this->repo = new CarsRepository(new Car());
    }

    public function create(CarsRequest $request)
    {
        $data = [
            'license' => $request->license,
            'model' => $request->model,
            'color' => $request->color,
            'owner' => $request->owner,
            'park_id' => $request->type
        ];


        try {
            $create = $this->repo->create($data);

            throw_if(is_null($create->id), new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('Car create', $create, 201, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 200, 'No create car');
        }


    }

    public function list()
    {
        $cars = $this->repo->all();
        try {

            throw_if($cars->count() === 0, new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('Data from Cars', CarResponse::collection($cars), 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 404, $this->NOT_FOUND);
        }

    }

    public function show(Request $request)
    {
        $cars = $this->repo->find($request->id);
        try {

            throw_if($cars->count() === 0, new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('Data from Cars', new CarResponse($cars), 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 404, $this->NOT_FOUND);
        }

    }

    public function update(Request $request){
        $id = $request->id;
        $data = [
            'model' => $request->model,
            'owner' => $request->owner,
            'type' => $request->type
        ];

        try {
                $car = $this->repo->find($id);
                $update = $car->update($data);
                $car->syncChanges();

            throw_if(!$update , new UpdateException('NOT UPDATE DATA'));
            return $this->responseManage()->response('Update Car', $car, 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 402, "Error update");
        }
    }

    public function delete(Request $request){
        $id = $request->id;


        try {
            $car = $this->repo->find($id);

            $del = $car->delete();

            throw_if(!$del , new \Exception('NOT DELETE DATA'));
            return $this->responseManage()->response('Delete Car', null, 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 402, "Error delete");
        }
    }
}
