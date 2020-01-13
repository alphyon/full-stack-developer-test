<?php


namespace App\Http\Controllers;


use App\Http\Resources\ParkResponse;
use App\Park;
use App\Http\Controllers\Utils\LogManger;
use App\Http\Controllers\Utils\ResponseUtils;
use App\Http\Exceptions\UpdateException;
use App\Http\Repositories\ParksRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class ParksController extends Controller
{
    protected $repo;

    public function __construct()
    {

        $this->repo = new ParksRepository(new Park());
    }

    public function create(Request $request)
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,

        ];


        try {
            $create = $this->repo->create($data);

            throw_if(is_null($create->id), new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('Park create', $create, 201, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 200, 'No create park');
        }


    }

    public function list()
    {
        $parks = $this->repo->all();
        try {
            throw_if($parks->count() === 0, new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('Data from Parks',ParkResponse::collection($parks), 200,
                null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 404, $this->NOT_FOUND);
        }

    }

    public function show(Request $request)
    {
        $parks = $this->repo->find($request->id);
        try {
            throw_if($parks->count() === 0, new \Exception('NOT FOUND DATA'));
            return $this->responseManage()->response('Data from Parks',new ParkResponse($parks), 200,
                null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 404, $this->NOT_FOUND);
        }

    }

    public function update(Request $request)
    {
        $id = $request->id;
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        try {
            $park = $this->repo->find($id);
            $update = $park->update($data);
            $park->syncChanges();

            throw_if(!$update, new UpdateException('NOT UPDATE DATA'));
            return $this->responseManage()->response('Update Park', $park, 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 402, "Error update");
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;


        try {
            $park = $this->repo->find($id);

            $del = $park->delete();

            throw_if(!$del, new \Exception('NOT DELETE DATA'));
            return $this->responseManage()->response('Delete Park', null, 200, null);
        } catch (\Exception $exception) {
            $this->logManager()->error($exception->getMessage());
            return $this->responseManage()->response(null, null, 402, "Error delete");
        }
    }
}
