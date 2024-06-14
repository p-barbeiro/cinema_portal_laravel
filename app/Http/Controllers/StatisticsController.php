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
    public function overall()
    {
        // Fetch overall statistics
        $totalSalesValue = Ticket::sum('price');
        $totalSalesQuantity = Ticket::count();

        // Category with most revenue and most ticket sales
        $categoryMostRevenue = DB::table('tickets')
            ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->join('genres', 'movies.genre_code', '=', 'genres.code')
            ->select('genres.name as category', DB::raw('SUM(tickets.price) as total_value'))
            ->groupBy('genres.name')
            ->orderBy('total_value', 'desc')
            ->first();

        $categoryMostTickets = DB::table('tickets')
            ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->join('genres', 'movies.genre_code', '=', 'genres.code')
            ->select('genres.name as category', DB::raw('COUNT(tickets.id) as total_quantity'))
            ->groupBy('genres.name')
            ->orderBy('total_quantity', 'desc')
            ->first();

        // Movie with most revenue and most ticket sales
        $movieMostRevenue = Movie::select('movies.title', DB::raw('SUM(tickets.price) as total_value'))
            ->join('screenings', 'movies.id', '=', 'screenings.movie_id')
            ->join('tickets', 'screenings.id', '=', 'tickets.screening_id')
            ->groupBy('movies.title')
            ->orderBy('total_value', 'desc')
            ->first();

        $movieMostTickets = Movie::select('movies.title', DB::raw('COUNT(tickets.id) as total_quantity'))
            ->join('screenings', 'movies.id', '=', 'screenings.movie_id')
            ->join('tickets', 'screenings.id', '=', 'tickets.screening_id')
            ->groupBy('movies.title')
            ->orderBy('total_quantity', 'desc')
            ->first();

        // Customer with total spent and total tickets bought
        $customerMostSpent = DB::table('purchases')
            ->select('customer_name', DB::raw('SUM(total_price) as total_spent'))
            ->groupBy('customer_name')
            ->orderBy('total_spent', 'desc')
            ->first();

        $customerMostTickets = DB::table('purchases')
            ->join('tickets', 'purchases.id', '=', 'tickets.purchase_id')
            ->select('purchases.customer_name', DB::raw('COUNT(tickets.id) as total_tickets'))
            ->groupBy('purchases.customer_name')
            ->orderBy('total_tickets', 'desc')
            ->first();

        return view('statistics.overall', compact(
            'totalSalesValue', 'totalSalesQuantity', 'categoryMostRevenue', 'categoryMostTickets', 'movieMostRevenue', 'movieMostTickets', 'customerMostSpent', 'customerMostTickets'
        ));
    }

    public function category()
    {
        // Fetch data for category statistics
        $salesByCategory = DB::table('tickets')
            ->join('screenings', 'tickets.screening_id', '=', 'screenings.id')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->join('genres', 'movies.genre_code', '=', 'genres.code')
            ->select('genres.name as category', DB::raw('SUM(tickets.price) as total_value'), DB::raw('COUNT(tickets.id) as total_quantity'))
            ->groupBy('genres.name')
            ->get();

        return view('statistics.category', compact('salesByCategory'));
    }

    public function movie()
    {
        // Fetch data for film statistics
        $salesByFilm = Movie::select('movies.title', DB::raw('SUM(tickets.price) as total_value'), DB::raw('COUNT(tickets.id) as total_quantity'))
            ->join('screenings', 'movies.id', '=', 'screenings.movie_id')
            ->join('tickets', 'screenings.id', '=', 'tickets.screening_id')
            ->groupBy('movies.title')
            ->get();

        return view('statistics.movie', compact('salesByFilm'));
    }

    public function customer()
    {
        // Fetch data for customer statistics
        $salesByCustomer = DB::table('purchases')
            ->select('customer_name', DB::raw('SUM(total_price) as total_value'), DB::raw('COUNT(id) as total_quantity'))
            ->groupBy('customer_name')
            ->get();

        return view('statistics.customer', compact('salesByCustomer'));
    }
}

