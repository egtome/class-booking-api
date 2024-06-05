<?php

namespace App\Services;

use Carbon\Carbon;

class DateService
{

    public function getEndOfCurrentWeekDatetime(): string
    {
        $currentDate = Carbon::now();
        $endOfWeek = $currentDate->endOfWeek();
        
        return $endOfWeek->toDateTimeString();
    }

    public function getNextAvailableSlotDatetime(): string
    {
        $currentDate = Carbon::now();
        $currentDate->addHour()->setMinutes(0)->setSeconds(0);

        return $currentDate->toDateTimeString();
    }

    public function getLastHourOfTheDayDatetime(): string
    {
        $currentDate = Carbon::now();
        $currentDate->endOfDay();

        return $currentDate->toDateTimeString();
    }

    public function getLastHourOfTheDayWithResetHoursAndMinutesDatetime(): string
    {
        $currentDate = Carbon::now();
        $currentDate->endOfDay()->setMinutes(0)->setSeconds(0);

        return $currentDate->toDateTimeString();
    }

    public function getNextSlotAvailableOfTheDayDatetime(int $dayNumber): string
    {
        $currentDayOfWeekNumber = Carbon::now()->dayOfWeek;

        $currentDate = Carbon::now();
        if ($dayNumber != $currentDayOfWeekNumber) {
            $currentDate = $currentDate->next($dayNumber);
        }
        
        $currentDate->addHour()->setMinutes(0)->setSeconds(0);

        return $currentDate->toDateTimeString();
    }

    public function getLastSlotAvailableOfTheDayDatetime(int $dayNumber): string
    {
        $currentDayOfWeekNumber = Carbon::now()->dayOfWeek;

        $currentDate = Carbon::now();
        if ($dayNumber != $currentDayOfWeekNumber) {
            $currentDate = $currentDate->next($dayNumber);
        }
        
        $currentDate->endOfDay()->setMinutes(0)->setSeconds(0);

        return $currentDate->toDateTimeString();
    }    
}