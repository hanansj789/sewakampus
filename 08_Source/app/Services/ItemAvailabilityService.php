<?php

namespace App\Services;

use App\Models\Item;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class ItemAvailabilityService
{
    /**
     * Status booking yang dianggap menempati tanggal.
     */
    public const OCCUPYING_STATUSES = [
        'PENDING',
        'APPROVED',
        'HANDED_OVER',
        'RETURNED',
        'COMPLETED',
        'DISPUTED',
    ];

    /**
     * @return list<string> tanggal Y-m-d yang tidak tersedia pada bulan itu
     */
    public function unavailableDates(Item $item, CarbonImmutable $month): array
    {
        $first = $month->startOfMonth();
        $last = $month->endOfMonth();

        $dates = [];

        foreach ($this->ranges($item, $first->toDateString(), $last->toDateString()) as $range) {
            $cursor = CarbonImmutable::parse($range['start'])->max($first);
            $end = CarbonImmutable::parse($range['end'])->min($last);

            while ($cursor->lessThanOrEqualTo($end)) {
                $dates[$cursor->toDateString()] = true;
                $cursor = $cursor->addDay();
            }
        }

        ksort($dates);

        return array_keys($dates);
    }

    public function isRangeAvailable(Item $item, string $startDate, string $endDate): bool
    {
        return $this->conflicts($item, $startDate, $endDate)->isEmpty();
    }

    /**
     * @return Collection<int, array{type: string, start: string, end: string}>
     */
    public function conflicts(Item $item, string $startDate, string $endDate): Collection
    {
        return collect($this->ranges($item, $startDate, $endDate))
            ->filter(fn (array $range) => $range['start'] <= $endDate && $range['end'] >= $startDate)
            ->values();
    }

    /**
     * @return list<array{type: string, start: string, end: string}>
     */
    private function ranges(Item $item, string $from, string $to): array
    {
        $blocked = $item->availabilities()
            ->where('status', 'BLOCKED')
            ->whereDate('start_date', '<=', $to)
            ->whereDate('end_date', '>=', $from)
            ->get(['start_date', 'end_date'])
            ->map(fn ($row) => [
                'type' => 'BLOCKED',
                'start' => $row->start_date->toDateString(),
                'end' => $row->end_date->toDateString(),
            ])
            ->all();

        $booked = $item->bookings()
            ->whereIn('status', self::OCCUPYING_STATUSES)
            ->whereDate('start_date', '<=', $to)
            ->whereDate('end_date', '>=', $from)
            ->get(['start_date', 'end_date'])
            ->map(fn ($row) => [
                'type' => 'BOOKING',
                'start' => $row->start_date->toDateString(),
                'end' => $row->end_date->toDateString(),
            ])
            ->all();

        return array_merge($blocked, $booked);
    }
}
