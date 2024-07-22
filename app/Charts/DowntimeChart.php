<?php

namespace App\Charts;

use Carbon\Carbon;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DowntimeChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($request): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $user = Auth::user();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $assetId = $request->input('asset_id');

        $monthlyDowntime = Ticket::getMonthlyDowntime($startDate, $endDate, $user, $assetId);

        // Initialize array for all months from January to current month
        $months = [];
        $downtimes = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->monthName;
            $months[] = $monthName;

            // Check if downtime exists for this month, if yes, use the value, else set to 0
            $downtimeValue = isset($monthlyDowntime[str_pad($i, 2, '0', STR_PAD_LEFT)]) ? $monthlyDowntime[str_pad($i, 2, '0', STR_PAD_LEFT)] : 0;
            // dd($monthlyDowntime);
            $downtimes[] = $downtimeValue;
            $markerColor = $downtimeValue > 1000 ? '#FF5722' : '#E040FB';
            $markerSize = $downtimeValue > 1000 ? 10 : 7;
            $markers[] = ['fillColor' => $markerColor, 'size' => $markerSize];
        }

        return $this->chart->barChart()
            ->setTitle('Downtime Tahun ' . date('Y'))
            ->addData('Downtime', $downtimes)
            ->setXAxis($months);
    }
}
