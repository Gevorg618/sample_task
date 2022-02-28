<?php

namespace App\Http\Controllers;

use App\Services\ExportService;
use Illuminate\Support\Facades\Log;

class ExportController extends Controller
{
    /**
     * @var ExportService
     */
    private $exportService;

    /**
     * ExportController constructor.
     * @param ExportService $exportService
     */
    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Export DB
     */
    public function export()
    {

        try {
            $file = $this->exportService->generateDbFile();
            return response()->download($file);
        } catch (\Exception $exception) {
            Log::info($exception);

            return response()->json([
                'success' => 0,
                'type' => 'error',
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }
}
