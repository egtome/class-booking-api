<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use App\Services\ClassroomService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    const DEFAULT_ERROR_PREFIX = 'error';


    protected $bookingService;
    protected $classroomService;

    public function __construct(BookingService $bookingService, ClassroomService $classroomService)
    {
        $this->bookingService = $bookingService;
        $this->classroomService = $classroomService;
    }

    public function getAvailableBooks(): JsonResponse
    {
        return response()->json(
            [
                'data' => $this->bookingService->getAvailableBooksInCurrentWeek(),
            ],
            Response::HTTP_OK
        );
    }

    public function bookClass(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'classroom_id' => 'required|exists:classrooms,id',
            'day_of_week' => 'required|numeric|between:0,6',
            'start_at_hour' => 'required|numeric|between:0,24',
        ]);
    
        if ($validator->fails()) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $params = $request->all();

        if (!$this->classroomService->hasClassroomDayNumberAvailable($params['classroom_id'], $params['day_of_week'])) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'Day of the week is not available in this classroom.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!$this->classroomService->doesClassroomStartAtHourexist($params['classroom_id'], $params['start_at_hour'], $params['day_of_week'])) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'Either start at hour does not exist for this classroom or the our already passed'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!$this->bookingService->hasClassroomCapacityToBook($params['classroom_id'], $params['start_at_hour'], $params['day_of_week'])) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'Sorry, classroom is full. Try a different timetable'], Response::HTTP_CONFLICT);
        }

        return response()->json(['result' => $this->bookingService->bookClass($params['classroom_id'], $params['start_at_hour'], $params['day_of_week'])], Response::HTTP_CREATED);
    }
    
    public function remove(Request $request)
    {
        $bookingId = $request->route('id');
        if (empty($bookingId)) {
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'Invalid ID'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $deleted = $this->bookingService->deleteById((int)$bookingId);

        if ($deleted === false) {
            // Invalid ID, or ID does not belong to user
            return response()->json([self::DEFAULT_ERROR_PREFIX => 'Forbidden'], Response::HTTP_FORBIDDEN);
        }

        return response()->json([''], Response::HTTP_NO_CONTENT);
    }    
}
