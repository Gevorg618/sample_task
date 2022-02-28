<?php

namespace App\Http\Controllers;

use App\Contracts\CardsInterface;
use App\Http\Requests\CardStoreRequest;
use App\Http\Requests\CardUpdateRequest;
use App\Http\Requests\ListCardRequest;
use App\Models\Card;
use Illuminate\Support\Facades\Log;

class CardController extends Controller
{
    /**
     * @var CardsInterface
     */
    private $cardsInterface;

    /**
     * CardController constructor.
     * @param Card $model
     * @param CardsInterface $cardsInterface
     */
    public function __construct(CardsInterface $cardsInterface)
    {
        $this->cardsInterface = $cardsInterface;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CardStoreRequest $request)
    {
        try {
            $data = $request->all();
            $this->cardsInterface->create($data);

            return response()->json([
                'success' => 1,
                'type'    => 'success',
                'message' => 'Card added'
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
     * @param CardUpdateRequest $request
     * @param Card $card
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CardUpdateRequest $request, Card $card)
    {
        try {
            $data = [
                'title' => $request->title,
                'description' => $request->description,
            ];
            $this->cardsInterface->update($data, $card->id);

            return response()->json([
                'success' => 1,
                'type' => 'success',
                'message' => 'Cards updated'
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

    public function listCards(ListCardRequest $request){

        $access_token = $request->input('access_token', false);
        $date = $request->input('date', null);
        $status = $request->input('status', 'not_status');
        try{
            if ($access_token && ($access_token == config('app.ACCESS_TOKEN'))){
                $cards = $this->cardsInterface->getListCards($date, $access_token, $status);
                return response()->json($cards);
            }
            return response()->json([
                'success' => 0,
                'type'    => 'error',
                'message' => 'You don\'t have access',
                'code'    => 422,
            ]);
        }catch (\Exception $exception){
            Log::info($exception);
            return response()->json([
                'success' => 0,
                'type'    => 'error',
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }
}
