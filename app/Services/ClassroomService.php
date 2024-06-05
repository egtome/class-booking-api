<?php

namespace App\Services;

use App\Models\Classroom;
use Carbon\Carbon;

class ClassroomService
{

    public function getById(int $classroomId): Classroom
    {
        return Classroom::find($classroomId);
    }

    public function getAll(): array
    {
        return Classroom::orderBy('name')->get()->toArray();
    }

    public function buildPossibleSlotsByClassroomId(int $classroomId): array
    {
        $slots = [];

        $classroom = $this->getById($classroomId);
        $intervalInHours = $classroom->slot_available_in_minutes / 60;

        for ($h=$classroom->hour_available_from; ($h + $intervalInHours) <= $classroom->hour_available_to; $h+=$intervalInHours) {
                $slots[$h] = [
                    'to' => $h + $intervalInHours,
                    'available' => true
                ];
        }

        return $slots;
    }

    public function hasClassroomDayNumberAvailable(int $classroomId, int $dayNumber): bool
    {
        $classroom = $this->getById($classroomId);
        $daysAvailable = explode(':', $classroom->days_available);

        return in_array($dayNumber, $daysAvailable);
    }
    
    public function doesClassroomStartAtHourexist(int $classroomId, int $startAtHour, ?int $weekDay = null): bool
    {
        $classroom = $this->getById($classroomId);
        $classroomSlots = $this->buildPossibleSlotsByClassroomId($classroomId);

        $allowedStartAt = $weekDay && $weekDay === Carbon::now()->dayOfWeek ? Carbon::now()->addHour()->hour : $classroom->hour_available_from;

        return ($startAtHour >= $allowedStartAt) && array_key_exists($startAtHour, $classroomSlots);
    }
   
}