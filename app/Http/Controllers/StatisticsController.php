<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatisticsFormRequest;
use Illuminate\Http\Request;
use App\Models\Theater;
use App\Models\Seat;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\User;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function overall(StatisticsFormRequest $request)
    {
        $filterByGenre = $request->input('genre');
        $filterByTheater = $request->input('theater');
        $filterByStartDate = $request->input('start_date');
        $filterByEndDate = $request->input('end_date');
        $theaterShow = true;
        $genreShow = true;

        // Fetch overall statistics
        $totalSalesValueQuery = Ticket::query();
        $totalSalesQuantityQuery = Ticket::query();

        if (!empty($filterByGenre)) {
            $totalSalesValueQuery->whereHas('screening.movie', function ($query) use ($filterByGenre) {
                $query->where('genre_code', $filterByGenre);
            });
            $totalSalesQuantityQuery->whereHas('screening.movie', function ($query) use ($filterByGenre) {
                $query->where('genre_code', $filterByGenre);
            });
        }

        if (!empty($filterByTheater)) {
            $totalSalesValueQuery->whereHas('screening', function ($query) use ($filterByTheater) {
                $query->where('theater_id', $filterByTheater);
            });
            $totalSalesQuantityQuery->whereHas('screening', function ($query) use ($filterByTheater) {
                $query->where('theater_id', $filterByTheater);
            });
        }

        if (!empty($filterByStartDate)) {
            $totalSalesValueQuery->whereHas('screening', function ($query) use ($filterByStartDate) {
                $query->where('date', '>=', $filterByStartDate);
            });
            $totalSalesQuantityQuery->whereHas('screening', function ($query) use ($filterByStartDate) {
                $query->where('date', '>=', $filterByStartDate);
            });
        }

        if (!empty($filterByEndDate)) {
            $totalSalesValueQuery->whereHas('screening', function ($query) use ($filterByEndDate) {
                $query->where('date', '<=', $filterByEndDate);
            });
            $totalSalesQuantityQuery->whereHas('screening', function ($query) use ($filterByEndDate) {
                $query->where('date', '<=', $filterByEndDate);
            });
        }

        $totalSalesValue = $totalSalesValueQuery->sum('price');
        $totalSalesQuantity = $totalSalesQuantityQuery->count();

        // Category with most revenue and most ticket sales
        $categoryQuery = DB::table('tickets')
            ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->join('genres', 'movies.genre_code', '=', 'genres.code')
            ->select('genres.name as category',
                DB::raw('SUM(tickets.price) as total_value'),
                DB::raw('COUNT(tickets.id) as total_quantity'))
            ->groupBy('genres.name');

        if (!empty($filterByGenre)) {
            $categoryQuery->where('movies.genre_code', $filterByGenre);
        }

        if (!empty($filterByTheater)) {
            $categoryQuery->where('screenings.theater_id', $filterByTheater);
        }

        if (!empty($filterByStartDate)) {
            $categoryQuery->where('screenings.date', '>=', $filterByStartDate);
        }

        if (!empty($filterByEndDate)) {
            $categoryQuery->where('screenings.date', '<=', $filterByEndDate);
        }

        $categoryStatistics = $categoryQuery->get();
        $categoryMostRevenue = optional($categoryStatistics->sortByDesc('total_value')->first());
        $categoryMostTickets = optional($categoryStatistics->sortByDesc('total_quantity')->first());

        // Movie with most revenue and most ticket sales
        $movieQuery = DB::table('movies')
            ->join('screenings as movie_screenings', 'movies.id', '=', 'movie_screenings.movie_id')
            ->join('tickets', 'movie_screenings.id', '=', 'tickets.screening_id')
            ->select('movies.title',
                DB::raw('SUM(tickets.price) as total_value'),
                DB::raw('COUNT(tickets.id) as total_quantity'))
            ->groupBy('movies.title');

        if (!empty($filterByGenre)) {
            $movieQuery->where('movies.genre_code', $filterByGenre);
        }

        if (!empty($filterByTheater)) {
            $movieQuery->where('movie_screenings.theater_id', $filterByTheater);
        }

        if (!empty($filterByStartDate)) {
            $movieQuery->where('movie_screenings.date', '>=', $filterByStartDate);
        }

        if (!empty($filterByEndDate)) {
            $movieQuery->where('movie_screenings.date', '<=', $filterByEndDate);
        }

        $movieStatistics = $movieQuery->get();
        $movieMostRevenue = optional($movieStatistics->sortByDesc('total_value')->first());
        $movieMostTickets = optional($movieStatistics->sortByDesc('total_quantity')->first());

        // Customer with total spent and total tickets bought
        $customerQuery = DB::table('purchases')
            ->join('tickets', 'purchases.id', '=', 'tickets.purchase_id')
            ->join('screenings as customer_screenings', 'tickets.screening_id', '=', 'customer_screenings.id')
            ->join('movies', 'customer_screenings.movie_id', '=', 'movies.id')
            ->select('purchases.customer_name',
                DB::raw('SUM(tickets.price) as total_spent'),
                DB::raw('COUNT(tickets.id) as total_tickets'))
            ->groupBy('purchases.customer_name');

        if (!empty($filterByGenre)) {
            $customerQuery->where('movies.genre_code', $filterByGenre);
        }

        if (!empty($filterByTheater)) {
            $customerQuery->where('customer_screenings.theater_id', $filterByTheater);
        }

        if (!empty($filterByStartDate)) {
            $customerQuery->where('customer_screenings.date', '>=', $filterByStartDate);
        }

        if (!empty($filterByEndDate)) {
            $customerQuery->where('customer_screenings.date', '<=', $filterByEndDate);
        }

        $customerStatistics = $customerQuery->get();
        $customerMostSpent = optional($customerStatistics->sortByDesc('total_spent')->first());
        $customerMostTickets = optional($customerStatistics->sortByDesc('total_tickets')->first());

        return view('statistics.overall', compact(
            'totalSalesValue', 'totalSalesQuantity',
            'categoryMostRevenue', 'categoryMostTickets',
            'movieMostRevenue', 'movieMostTickets',
            'customerMostSpent', 'customerMostTickets',
            'filterByGenre', 'filterByTheater', 'filterByStartDate',
            'filterByEndDate', 'theaterShow', 'genreShow'
        ));
    }

    public function theater(StatisticsFormRequest $request)
    {
        $filterByStartDate = $request->input('start_date');
        $filterByEndDate = $request->input('end_date');
        $theaterShow = false;
        $genreShow = false;

        // Calculate total seats and occupied seats
        $theaterSeats = DB::table('seats')
            ->select('theater_id', DB::raw('COUNT(*) as total_seats'))
            ->whereNull('deleted_at')
            ->groupBy('theater_id');

        // Calculate occupied seats per screening
        $screeningOccupiedSeats = DB::table('tickets')
            ->select('screening_id', DB::raw('COUNT(*) as occupied_seats'))
            ->whereNull('deleted_at')
            ->groupBy('screening_id');

        // Fetch data for theater statistics
        $theaterStatistics = DB::table('theaters')
            ->leftJoinSub($theaterSeats, 'seats', function ($join) {
                $join->on('theaters.id', '=', 'seats.theater_id');
            })
            ->leftJoin('screenings', 'theaters.id', '=', 'screenings.theater_id')
            ->leftJoin('tickets', 'screenings.id', '=', 'tickets.screening_id')
            ->select('theaters.name as Theater_Name',
                DB::raw('SUM(tickets.price) as Total_Sales_Value'),
                DB::raw('COUNT(tickets.id) as Total_Tickets_Sold'),
                'seats.total_seats as Total_Seats',
                DB::raw('ROUND((COUNT(tickets.id) / (seats.total_seats * COUNT(DISTINCT screenings.id))) * 100, 2) as Occupancy_Rate'))
            ->whereNull('theaters.deleted_at')
            ->groupBy('theaters.id', 'theaters.name', 'seats.total_seats')
            ->orderBy('Total_Sales_Value', 'desc');

        if (!empty($filterByStartDate)) {
            $theaterStatistics->where('screenings.date', '>=', $filterByStartDate);
        }

        if (!empty($filterByEndDate)) {
            $theaterStatistics->where('screenings.date', '<=', $filterByEndDate);
        }

        $statistics = $theaterStatistics->paginate(20);

        return view('statistics.theater', compact('statistics',
            'filterByStartDate', 'filterByEndDate', 'theaterShow',
            'genreShow'));
    }

    public function movie(StatisticsFormRequest $request)
    {
        $filterByGenre = $request->input('genre');
        $filterByTheater = $request->input('theater');
        $filterByStartDate = $request->input('start_date');
        $filterByEndDate = $request->input('end_date');
        $theaterShow = true;
        $genreShow = true;

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
        $statisticsQuery = DB::table('movies')
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
            ->orderBy('total_value', 'desc');

        if (!empty($filterByGenre)) {
            $statisticsQuery->where('movies.genre_code', $filterByGenre);
        }

        if (!empty($filterByTheater)) {
            $statisticsQuery->where('screenings.theater_id', $filterByTheater);
        }

        if (!empty($filterByStartDate)) {
            $statisticsQuery->where('screenings.date', '>=', $filterByStartDate);
        }

        if (!empty($filterByEndDate)) {
            $statisticsQuery->where('screenings.date', '<=', $filterByEndDate);
        }

        $statistics = $statisticsQuery->paginate(20);

        return view('statistics.movie', compact('statistics',
            'filterByGenre', 'filterByTheater', 'filterByStartDate',
            'filterByEndDate', 'theaterShow', 'genreShow'));
    }


    public function screening(StatisticsFormRequest $request)
    {
        $filterByGenre = $request->input('genre');
        $filterByTheater = $request->input('theater');
        $filterByStartDate = $request->input('start_date');
        $filterByEndDate = $request->input('end_date');
        $theaterShow = true;
        $genreShow = true;

        // Calculate total seats per screening
        $screeningSeats = DB::table('seats')
            ->select('screenings.id as screening_id', DB::raw('COUNT(seats.id) as total_seats'))
            ->join('screenings', 'seats.theater_id', '=', 'screenings.theater_id')
            ->groupBy('screenings.id');

        // Calculate occupied seats per screening
        $screeningOccupancy = DB::table('tickets')
            ->select('screening_id', DB::raw('COUNT(*) as occupied_seats'))
            ->groupBy('screening_id');

        // Fetch combined data for screening statistics
        $statisticsQuery = DB::table('screenings')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->join('genres', 'movies.genre_code', '=', 'genres.code')
            ->join('theaters', 'screenings.theater_id', '=', 'theaters.id')
            ->joinSub($screeningSeats, 'seats', function ($join) {
                $join->on('screenings.id', '=', 'seats.screening_id');
            })
            ->joinSub($screeningOccupancy, 'occupancy', function ($join) {
                $join->on('screenings.id', '=', 'occupancy.screening_id');
            })
            ->select('screenings.id as screening_id', 'movies.title as movie_title', 'genres.name as genre', 'theaters.name as theater_name',
                DB::raw('SUM(tickets.price) as total_sales'),
                DB::raw('(occupancy.occupied_seats / seats.total_seats) * 100 as occupancy_rate'))
            ->leftJoin('tickets', 'screenings.id', '=', 'tickets.screening_id')
            ->groupBy('screenings.id', 'movies.title', 'genres.name', 'theaters.name', 'seats.total_seats', 'occupancy.occupied_seats')
            ->orderBy('occupancy_rate', 'desc');

        if (!empty($filterByGenre)) {
            $statisticsQuery->where('movies.genre_code', $filterByGenre);
        }

        if (!empty($filterByTheater)) {
            $statisticsQuery->where('screenings.theater_id', $filterByTheater);
        }

        if (!empty($filterByStartDate)) {
            $statisticsQuery->where('screenings.date', '>=', $filterByStartDate);
        }

        if (!empty($filterByEndDate)) {
            $statisticsQuery->where('screenings.date', '<=', $filterByEndDate);
        }

        $statistics = $statisticsQuery->paginate(20);

        return view('statistics.screening', compact('statistics',
            'filterByGenre', 'filterByTheater', 'filterByStartDate',
            'filterByEndDate', 'theaterShow', 'genreShow'));
    }


    public function customer(StatisticsFormRequest $request)
    {
        $filterByGenre = $request->input('genre');
        $filterByTheater = $request->input('theater');
        $filterByStartDate = $request->input('start_date');
        $filterByEndDate = $request->input('end_date');
        $theaterShow = true;
        $genreShow = true;

        // Fetch data for customer statistics
        $statisticsQuery = DB::table('purchases')
            ->join('tickets', 'purchases.id', '=', 'tickets.purchase_id')
            ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->select('purchases.customer_name', 'purchases.customer_email',
                DB::raw('COUNT(tickets.id) as tickets_purchased'),
                DB::raw('SUM(tickets.price) as total_sales'))
            ->groupBy('purchases.customer_name', 'purchases.customer_email')
            ->orderBy('total_sales', 'desc');

        if (!empty($filterByGenre)) {
            $statisticsQuery->where('movies.genre_code', $filterByGenre);
        }

        if (!empty($filterByTheater)) {
            $statisticsQuery->where('screenings.theater_id', $filterByTheater);
        }

        if (!empty($filterByStartDate)) {
            $statisticsQuery->where('screenings.date', '>=', $filterByStartDate);
        }

        if (!empty($filterByEndDate)) {
            $statisticsQuery->where('screenings.date', '<=', $filterByEndDate);
        }

        $statistics = $statisticsQuery->paginate(20);

        return view('statistics.customer', compact('statistics',
            'filterByGenre', 'filterByTheater', 'filterByStartDate',
            'filterByEndDate', 'theaterShow', 'genreShow'));
    }


}
