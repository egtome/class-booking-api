<?php

namespace App\Services;

use App\Models\Operation;
use App\Models\User;
use App\Models\UserOperation;
use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingService
{
    protected $dateService;
    protected $classroomService;

    public function __construct(DateService $dateService, ClassroomService $classroomService)
    {
        $this->dateService = $dateService;
        $this->classroomService = $classroomService;
    }

    public function getAvailableBooksInCurrentWeek(): array
    {
        $availableClasses = [];

        $currentDayOfWeekNumber = Carbon::now()->dayOfWeek;
        $dateFrom = $this->dateService->getNextAvailableSlotDatetime();
        $dateEnd = $this->dateService->getEndOfCurrentWeekDatetime();

        $classrooms = $this->classroomService->getAll();

        foreach ($classrooms as $classroom) {
            $possibleSlots = $this->classroomService->buildPossibleSlotsByClassroomId($classroom['id']);
            $daysAvailable = explode(':', $classroom['days_available']);
            foreach ($daysAvailable as $dayAvailable) {
                if ($dayAvailable >= $currentDayOfWeekNumber) {
                    $allowedStartAt = $dayAvailable == $currentDayOfWeekNumber ? Carbon::now()->addHour()->hour : $classroom['hour_available_from'];
                    $bookingsOfTheDay = $this->getBookingsOfTheDayByClassroomId($classroom['id'], $dayAvailable);
                    
                    foreach ($bookingsOfTheDay as $booking) {
                        if (($booking['total'] < $classroom['capacity']) && $booking['start_at_hour'] >= $allowedStartAt) {
                            $availableClasses[$classroom['name']][$dayAvailable][$booking['start_at_hour']] = [
                                'from' => $booking['start_at_hour'],
                                'to' => $possibleSlots[$booking['start_at_hour']]['to'],
                                'places_available' => $classroom['capacity'] - $booking['total']
                            ];
                        } else {
                            $possibleSlots[$booking['start_at_hour']]['available'] = false;
                        }
                    }

                    foreach ($possibleSlots as $slotFrom => $slot) {
                        if (empty($availableClasses[$classroom['name']][$dayAvailable][$slotFrom]) && $slotFrom >= $allowedStartAt) {
                            $availableClasses[$classroom['name']][$dayAvailable][$slotFrom] = [
                                'from' => $slotFrom,
                                'to' => $slot['to'],
                                'places_available' => $classroom['capacity']
                            ];                            
                        }
                    }
                    
                    ksort($availableClasses[$classroom['name']][$dayAvailable]);
                }
            }

            
        }
        
        return $availableClasses;
    }

    public function getBookingsOfTheDayByClassroomId(int $classroomId, int $dayNumber): array
    {
        $dateFrom = $this->dateService->getNextSlotAvailableOfTheDayDatetime($dayNumber);
        $dateTo = $this->dateService->getLastSlotAvailableOfTheDayDatetime($dayNumber);

        return Booking::selectRaw('start_at, COUNT(*) as total')
            ->where('classroom_id', $classroomId)
            ->where('start_at', '>=' , $dateFrom)
            ->where('end_at', '<=' , $dateTo)
            ->groupBy('start_at')
            ->orderBy('start_at', 'asc')
            ->get()
            ->map(function($event) {
                $startAt = Carbon::parse($event->start_at);             
                $event->start_at_hour = $startAt->hour;
                
                return $event;
            })->toArray();     
    }
    
    public function hasClassroomCapacityToBook(int $classroomId, int $startAtHour, int $dayOfTheWeek): bool
    {
        $hasCapacity = true;

        $classroom = $this->classroomService->getById($classroomId);
        $bookingsOfTheDay = $this->getBookingsOfTheDayByClassroomId($classroomId, $dayOfTheWeek);

        foreach ($bookingsOfTheDay as $booking) {
            if ($booking['start_at_hour'] == $startAtHour) {
                $hasCapacity = $booking['total'] <= $classroom->capacity;

                break;
            }
        }
        
        return $hasCapacity;
    }

    public function bookClass(int $classroomId, int $startAtHour, int $dayOfTheWeek): Booking
    {
        // Calculate Start and End
        $classroom = $this->classroomService->getById($classroomId);
        $currentDayOfWeekNumber = Carbon::now()->dayOfWeek;

        $currentDate = Carbon::now();
        if ($dayOfTheWeek != $currentDayOfWeekNumber) {
            $currentDate = $currentDate->next($dayOfTheWeek);
        }
        $startAt = $currentDate->setHour($startAtHour)->setMinute(0)->setSecond(0)->toDateTimeString();
        $endAt = Carbon::parse($startAt);
        $endAt->addMinutes($classroom->slot_available_in_minutes);

        return Booking::create([
            'user_id' => Auth::user()->id,            
            'classroom_id' => $classroomId,
            'start_at' => $startAt,
            'end_at' => $endAt->toDateTimeString(),
        ]);        
    } 
    
    public function deleteById(int $id): bool|null
    {
        $user = User::find(Auth::user()->id);
        $booking = Booking::find($id);

        if (!$booking || ($booking->user_id !== $user->id)) {
            return false;
        }

        return $booking->delete();
    }     
}