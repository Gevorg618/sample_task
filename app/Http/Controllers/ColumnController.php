<?php

namespace App\Http\Controllers;

use App\Contracts\ColumnsInterface;
use App\Http\Requests\ColumnStoreRequest;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ColumnController extends Controller
{
    /**
     * @var ColumnsInterface
     */
    private $columnsInterface;

    /**
     * ColumnController constructor.
     * @param Column $model
     * @param ColumnsInterface $columnsInterface
     */
    public function __construct(ColumnsInterface $columnsInterface)
    {
        $this->columnsInterface = $columnsInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $relations = ['cards'];
            $columns = $this->columnsInterface->all($relations);

            return response()->json([
                'success' => 1,
                'type'    => 'success',
                'items'   => $columns
            ], 200);
        } catch (\Exception $exception) {
            Log::info($exception);
            return response()->json([
                'success' => 0,
                'type'    => 'error',
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }

    /**
     * @param ColumnStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ColumnStoreRequest $request)
    {
        try {
            $data = $request->all();
            $this->columnsInterface->create($data);

            return response()->json([
                'success' => 1,
                'type'    => 'success',
                'message' => 'Column added'
            ], 201);
        } catch (\Exception $exception) {
            Log::info($exception);
            return response()->json([
                'success' => 0,
                'type'    => 'error',
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        try {
            $this->columnsInterface->update($data);

            return response()->json([
                'success' => 1,
                'type'    => 'success',
                'message' => 'Columns updated'
            ], 201);

        } catch (\Exception $exception) {
            Log::info($exception);
            return response()->json([
                'success' => 0,
                'type' => 'error',
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function destroy(Column $column)
    {
        try {
            if ($column){
                $column->delete();
                $column->cards()->delete();

                return response()->json([
                    'success' => 1,
                    'type'    => 'success',
                    'message' => 'Deleted'
                ], 200);
            }
            return response()->json([
                'success' => 0,
                'type'    => 'error',
                'message' => 'Error',
                'code'    => 422
            ]);
        } catch (\Exception $exception) {
            Log::info($exception);

            return response()->json([
                'success' => 0,
                'type'    => 'error',
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }
}
