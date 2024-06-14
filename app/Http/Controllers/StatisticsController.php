<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Ticket;
use App\Models\Screening;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function overall()
    {
        // Fetch overall statistics
        $totalSalesValue = Ticket::sum('price');
        $totalSalesQuantity = Ticket::count();

        // Category with most revenue and most ticket sales
        $categoryStatistics = DB::table('tickets')
            ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->join('genres', 'movies.genre_code', '=', 'genres.code')
            ->select('genres.name as category',
                DB::raw('SUM(tickets.price) as total_value'),
                DB::raw('COUNT(tickets.id) as total_quantity'))
            ->groupBy('genres.name')
            ->get();

        $categoryMostRevenue = $categoryStatistics->sortByDesc('total_value')->first();
        $categoryMostTickets = $categoryStatistics->sortByDesc('total_quantity')->first();

        // Movie with most revenue and most ticket sales
        $movieStatistics = Movie::select('movies.title',
            DB::raw('SUM(tickets.price) as total_value'),
            DB::raw('COUNT(tickets.id) as total_quantity'))
            ->join('screenings', 'movies.id', '=', 'screenings.movie_id')
            ->join('tickets', 'screenings.id', '=', 'tickets.screening_id')
            ->groupBy('movies.title')
            ->get();

        $movieMostRevenue = $movieStatistics->sortByDesc('total_value')->first();
        $movieMostTickets = $movieStatistics->sortByDesc('total_quantity')->first();

        // Customer with total spent and total tickets bought
        $customerStatistics = DB::table('purchases')
            ->join('tickets', 'purchases.id', '=', 'tickets.purchase_id')
            ->select('purchases.customer_name',
                DB::raw('SUM(purchases.total_price) as total_spent'),
                DB::raw('COUNT(tickets.id) as total_tickets'))
            ->groupBy('purchases.customer_name')
            ->get();

        $customerMostSpent = $customerStatistics->sortByDesc('total_spent')->first();
        $customerMostTickets = $customerStatistics->sortByDesc('total_tickets')->first();

        return view('statistics.overall', compact(
            'totalSalesValue', 'totalSalesQuantity',
            'categoryMostRevenue', 'categoryMostTickets',
            'movieMostRevenue', 'movieMostTickets',
            'customerMostSpent', 'customerMostTickets'
        ));
    }

    public function movie()
    {
        // Calculate total seats per theater
        $theaterSeats = DB::table('seats')
            ->select('theater_id', DB::raw('COUNT(*) as total_seats'))
            ->groupBy('theater_id');

        // Calculate occupied seats per screening
        $screeningOccupancy = DB::table('tickets')
            ->select('screening_id', DB::raw('COUNT(*) as occupied_seats'))
            ->groupBy('screening_id');

        // Calculate total occupied seats and total seats per movie
        $movieOccupancy = DB::table('screenings')
            ->joinSub($screeningOccupancy, 'occupied', function ($join) {
                $join->on('screenings.id', '=', 'occupied.screening_id');
            })
            ->joinSub($theaterSeats, 'seats', function ($join) {
                $join->on('screenings.theater_id', '=', 'seats.theater_id');
            })
            ->select('screenings.movie_id',
                DB::raw('SUM(occupied.occupied_seats) as total_occupied_seats'),
                DB::raw('SUM(seats.total_seats) as total_seats'))
            ->groupBy('screenings.movie_id');

        // Calculate average occupancy per movie
        $movieAverageOccupancy = DB::table('screenings')
            ->joinSub($screeningOccupancy, 'occupied', function ($join) {
                $join->on('screenings.id', '=', 'occupied.screening_id');
            })
            ->joinSub($theaterSeats, 'seats', function ($join) {
                $join->on('screenings.theater_id', '=', 'seats.theater_id');
            })
            ->select('screenings.movie_id',
                DB::raw('AVG(occupied.occupied_seats / seats.total_seats) * 100 as average_occupancy'))
            ->groupBy('screenings.movie_id');

        // Fetch combined data for film and category statistics
        $salesByFilmAndCategory = DB::table('movies')
            ->join('screenings', 'movies.id', '=', 'screenings.movie_id')
            ->join('tickets', 'screenings.id', '=', 'tickets.screening_id')
            ->join('genres', 'movies.genre_code', '=', 'genres.code')
            ->joinSub($movieOccupancy, 'occupancy', function ($join) {
                $join->on('movies.id', '=', 'occupancy.movie_id');
            })
            ->joinSub($movieAverageOccupancy, 'avg_occ', function ($join) {
                $join->on('movies.id', '=', 'avg_occ.movie_id');
            })
            ->select('genres.name as genre', 'movies.title',
                DB::raw('SUM(tickets.price) as total_value'),
                DB::raw('COUNT(tickets.id) as total_quantity'),
                DB::raw('COUNT(DISTINCT screenings.id) as total_screenings'),
                'avg_occ.average_occupancy')
            ->groupBy('genres.name', 'movies.title', 'avg_occ.average_occupancy')
            ->orderBy('total_value', 'desc')
            ->paginate(20);

        return view('statistics.movie', compact('salesByFilmAndCategory'));
    }

    public function customer()
    {
        // Fetch data for customer statistics
        $salesByCustomer = DB::table('purchases')
            ->select('customer_name', 'customer_email',
                DB::raw('SUM(total_price) as total_value'),
                DB::raw('COUNT(id) as total_quantity'))
            ->groupBy('customer_name', 'customer_email')
            ->orderBy('total_value', 'desc')
            ->paginate(20);

        return view('statistics.customer', compact('salesByCustomer'));
    }

    public function screening()
    {
        // Fetch data for screening statistics
        $salesByScreening = Screening::select('screenings.id',
            'movies.title as movie', 'screenings.date', 'screenings.start_time',
            DB::raw('SUM(tickets.price) as total_value'),
            DB::raw('COUNT(tickets.id) as total_quantity'))
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->join('tickets', 'screenings.id', '=', 'tickets.screening_id')
            ->groupBy('screenings.id', 'movies.title', 'screenings.date', 'screenings.start_time')
            ->orderBy('total_value', 'desc')
            ->paginate(20);

        return view('statistics.screening', compact('salesByScreening'));
    }

    public function theater()
    {
        // Calculate total seats and occupied seats
        $theaterSeats = DB::table('seats')
            ->select('theater_id', DB::raw('COUNT(*) as total_seats'))
            ->groupBy('theater_id');

        $screeningOccupiedSeats = DB::table('tickets')
            ->select('screening_id', DB::raw('COUNT(*) as occupied_seats'))
            ->groupBy('screening_id');

        $averageOccupiedSeats = DB::table('screenings')
            ->joinSub($screeningOccupiedSeats, 'occupied', function ($join) {
                $join->on('screenings.id', '=', 'occupied.screening_id');
            })
            ->select('screenings.theater_id', DB::raw('AVG(occupied.occupied_seats) as average_occupied_seats'))
            ->groupBy('screenings.theater_id');

        // Fetch data for theater statistics
        $salesByTheater = DB::table('theaters')
            ->leftJoinSub($theaterSeats, 'seats', function ($join) {
                $join->on('theaters.id', '=', 'seats.theater_id');
            })
            ->leftJoinSub($averageOccupiedSeats, 'avg_occupied', function ($join) {
                $join->on('theaters.id', '=', 'avg_occupied.theater_id');
            })
            ->leftJoin('screenings', 'theaters.id', '=', 'screenings.theater_id')
            ->leftJoin('tickets', 'screenings.id', '=', 'tickets.screening_id')
            ->select('theaters.name',
                DB::raw('SUM(tickets.price) as total_value'),
                DB::raw('COUNT(tickets.id) as total_quantity'),
                'seats.total_seats',
                'avg_occupied.average_occupied_seats',
                DB::raw('(avg_occupied.average_occupied_seats / seats.total_seats) * 100 as percentage_occupancy')
            )
            ->groupBy('theaters.id', 'theaters.name', 'seats.total_seats', 'avg_occupied.average_occupied_seats')
            ->orderBy('total_value', 'desc')
            ->paginate(20);

        return view('statistics.theater', compact('salesByTheater'));
    }
}
