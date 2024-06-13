<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Ticket;
use App\Models\Screening;
use App\Models\Movie;
use App\Models\Theater;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        // Total ticket sales by value and quantity
        $totalSalesValue = Ticket::sum('price');
        $totalSalesQuantity = Ticket::count();

        // Ticket sales by month
        $salesByMonth = Ticket::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(price) as total_value'),
            DB::raw('COUNT(*) as total_quantity')
        )
            ->groupBy('year', 'month')
            ->get();

        // Ticket sales by year
        $salesByYear = Ticket::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(price) as total_value'),
            DB::raw('COUNT(*) as total_quantity')
        )
            ->groupBy('year')
            ->get();

        // Ticket sales by film
        $salesByFilm = Movie::select('movies.title', DB::raw('SUM(tickets.price) as total_value'), DB::raw('COUNT(tickets.id) as total_quantity'))
            ->join('screenings', 'movies.id', '=', 'screenings.movie_id')
            ->join('tickets', 'screenings.id', '=', 'tickets.screening_id')
            ->groupBy('movies.title')
            ->get();

        // Theater occupancy rates
        $occupancyRates = Theater::select('theaters.name', DB::raw('SUM(tickets.price) as total_value'), DB::raw('COUNT(tickets.id) as total_quantity'))
            ->join('screenings', 'theaters.id', '=', 'screenings.theater_id')
            ->join('tickets', 'screenings.id', '=', 'tickets.screening_id')
            ->groupBy('theaters.name')
            ->get();

        // Pass the data to the view
        return view('statistics.index', compact(
            'totalSalesValue', 'totalSalesQuantity', 'salesByMonth', 'salesByYear', 'salesByFilm', 'occupancyRates'
        ));
    }
}
