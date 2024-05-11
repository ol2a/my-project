<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Contracts\CrudInterface;
use App\Http\Requests\Api\V1\User\UserRequest;
use App\Http\Controllers\Api\V1\User\UserController
use App\Models\User;
use App\Traits\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use Response;

    public $model = User::class;

    public function __construct(private CrudInterface $CrudInterface){
        $this->CrudInterface->boot(model:$this->model);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->CrudInterface->index([]);

        return $this->success(status:HttpResponse::HTTP_OK , message:'data retrived' , data: $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try{
            DB::beginTransaction();

            $data = $this->CrudInterface->store($request->validated());

            DB::commit();

            return $this->success(status:HttpResponse::HTTP_OK , message:'data retrived' , data: $data);

        }catch(Exception $e){
            DB::rollBack();
            return $this->error(status:HttpResponse::HTTP_INTERNAL_SERVER_ERROR , message:$e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->CrudInterface->show($id , []);

        if(!$data){
            return $this->error(status:HttpResponse::HTTP_INTERNAL_SERVER_ERROR , message:'data not found');
        }

        return $this->success(status:HttpResponse::HTTP_OK , message:'data retrived' , data: $data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        try{
            $data = $this->CrudInterface->show($id , []);

            if(!$data){
                return $this->error(status:HttpResponse::HTTP_INTERNAL_SERVER_ERROR , message:'data not found');
            }

            DB::beginTransaction();

            $data->update($request->validated());

            DB::commit();

            return $this->success(status:HttpResponse::HTTP_OK , message:'data retrived' , data: $data);

        }catch(Exception $e){
            DB::rollBack();
            return $this->error(status:HttpResponse::HTTP_INTERNAL_SERVER_ERROR , message:$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


    }

}
