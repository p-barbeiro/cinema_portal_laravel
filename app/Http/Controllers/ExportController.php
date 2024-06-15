<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theater;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Purchase;
use App\Models\Ticket;
use App\Models\Genre;
use App\Models\Seat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    public function exportOverallStatistics(Request $request)
    {
        $filterByGenre = $request->input('genre');
        $filterByTheater = $request->input('theater');
        $filterByStartDate = $request->input('start_date');
        $filterByEndDate = $request->input('end_date');

        // Fetch overall statistics with filters applied
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

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'Overall Sales');
        $sheet->setCellValue('A2', 'Ticket Sales Value');
        $sheet->setCellValue('B2', number_format($totalSalesValue, 2));
        $sheet->setCellValue('A3', 'Ticket Sales Quantity');
        $sheet->setCellValue('B3', $totalSalesQuantity);

        $sheet->setCellValue('A5', 'Top Category');
        $sheet->setCellValue('A6', 'Most Revenue');
        $sheet->setCellValue('B6', $categoryMostRevenue->category ?? 'N/A');
        $sheet->setCellValue('C6', number_format($categoryMostRevenue->total_value ?? 0, 2));
        $sheet->setCellValue('A7', 'Total Ticket Sales');
        $sheet->setCellValue('B7', $categoryMostTickets->category ?? 'N/A');
        $sheet->setCellValue('C7', $categoryMostTickets->total_quantity ?? 0);

        $sheet->setCellValue('A9', 'Top Movie');
        $sheet->setCellValue('A10', 'Most Revenue');
        $sheet->setCellValue('B10', $movieMostRevenue->title ?? 'N/A');
        $sheet->setCellValue('C10', number_format($movieMostRevenue->total_value ?? 0, 2));
        $sheet->setCellValue('A11', 'Total Ticket Sales');
        $sheet->setCellValue('B11', $movieMostTickets->title ?? 'N/A');
        $sheet->setCellValue('C11', $movieMostTickets->total_quantity ?? 0);

        $sheet->setCellValue('A13', 'Top Customer');
        $sheet->setCellValue('A14', 'Most Spent');
        $sheet->setCellValue('B14', $customerMostSpent->customer_name ?? 'N/A');
        $sheet->setCellValue('C14', number_format($customerMostSpent->total_spent ?? 0, 2));
        $sheet->setCellValue('A15', 'Tickets Bought');
        $sheet->setCellValue('B15', $customerMostTickets->customer_name ?? 'N/A');
        $sheet->setCellValue('C15', $customerMostTickets->total_tickets ?? 0);

        // Write the file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'overall_statistics.xlsx';
        $filePath = storage_path('app/public/' . $fileName);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function exportTheaterStatistics(Request $request)
    {
        $filterByStartDate = $request->input('start_date');
        $filterByEndDate = $request->input('end_date');

        // Fetch data
        $theaters = Theater::with(['screenings.tickets', 'seats'])
            ->when($filterByStartDate, function ($query) use ($filterByStartDate) {
                $query->whereHas('screenings', function ($query) use ($filterByStartDate) {
                    $query->where('date', '>=', $filterByStartDate);
                });
            })
            ->when($filterByEndDate, function ($query) use ($filterByEndDate) {
                $query->whereHas('screenings', function ($query) use ($filterByEndDate) {
                    $query->where('date', '<=', $filterByEndDate);
                });
            })
            ->get();

        $statistics = $theaters->map(function ($theater) {
            $totalSalesValue = $theater->screenings->sum(function ($screening) {
                return $screening->tickets->sum('price');
            });
            $totalTicketsSold = $theater->screenings->sum(function ($screening) {
                return $screening->tickets->count();
            });
            $totalSeats = $theater->seats->count();
            $totalScreenings = $theater->screenings->count();

            $occupancyRate = $totalSeats > 0 && $totalScreenings > 0
                ? ($totalTicketsSold / ($totalSeats * $totalScreenings)) * 100
                : 0;

            return (object)[
                'Theater_Name' => $theater->name,
                'Total_Seats' => $totalSeats,
                'Total_Tickets_Sold' => $totalTicketsSold,
                'Total_Sales_Value' => $totalSalesValue,
                'Occupancy_Rate' => round($occupancyRate, 2)
            ];
        });

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'Theater Name');
        $sheet->setCellValue('B1', 'Total Seats');
        $sheet->setCellValue('C1', 'Tickets Sold');
        $sheet->setCellValue('D1', 'Total Sales');
        $sheet->setCellValue('E1', 'Occupancy Rate (%)');

        // Populate the data
        $row = 2;
        foreach ($statistics as $statistic) {
            $sheet->setCellValue('A' . $row, $statistic->Theater_Name);
            $sheet->setCellValue('B' . $row, $statistic->Total_Seats);
            $sheet->setCellValue('C' . $row, $statistic->Total_Tickets_Sold);
            $sheet->setCellValue('D' . $row, number_format($statistic->Total_Sales_Value, 2));
            $sheet->setCellValue('E' . $row, number_format($statistic->Occupancy_Rate, 2) . '%');
            $row++;
        }

        // Write the file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'theater_statistics.xlsx';
        $filePath = storage_path('app/public/' . $fileName);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function exportMoviesStatistics(Request $request)
    {
        $filterByGenre = $request->input('genre');
        $filterByStartDate = $request->input('start_date');
        $filterByEndDate = $request->input('end_date');

        // Fetch data
        $movies = Movie::with(['screenings.tickets', 'screenings.theater.seats', 'genre'])
            ->when($filterByGenre, function ($query) use ($filterByGenre) {
                $query->where('genre_code', $filterByGenre);
            })
            ->when($filterByStartDate, function ($query) use ($filterByStartDate) {
                $query->whereHas('screenings', function ($query) use ($filterByStartDate) {
                    $query->where('date', '>=', $filterByStartDate);
                });
            })
            ->when($filterByEndDate, function ($query) use ($filterByEndDate) {
                $query->whereHas('screenings', function ($query) use ($filterByEndDate) {
                    $query->where('date', '<=', $filterByEndDate);
                });
            })
            ->get();

        $statistics = $movies->map(function ($movie) {
            $totalSalesValue = $movie->screenings->sum(function ($screening) {
                return $screening->tickets->sum('price');
            });
            $totalTicketsSold = $movie->screenings->sum(function ($screening) {
                return $screening->tickets->count();
            });
            $totalScreenings = $movie->screenings->count();
            $totalSeats = $movie->screenings->sum(function ($screening) {
                return $screening->theater ? $screening->theater->seats->count() : 0;
            });

            $occupancyRate = $totalSeats > 0 && $totalScreenings > 0
                ? ($totalTicketsSold / ($totalSeats * $totalScreenings)) * 100
                : 0;

            return (object)[
                'Movie_Title' => $movie->title,
                'Genre' => optional($movie->genre)->name,
                'Total_Tickets_Sold' => $totalTicketsSold,
                'Total_Sales_Value' => $totalSalesValue,
                'Total_Screenings' => $totalScreenings,
                'Occupancy_Rate' => round($occupancyRate, 2)
            ];
        });

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'Movie');
        $sheet->setCellValue('B1', 'Genre');
        $sheet->setCellValue('C1', 'Tickets Sold');
        $sheet->setCellValue('D1', 'Total Sales');
        $sheet->setCellValue('E1', 'Total Screenings');
        $sheet->setCellValue('F1', 'Occupancy Rate (%)');

        // Populate the data
        $row = 2;
        foreach ($statistics as $statistic) {
            $sheet->setCellValue('A' . $row, $statistic->Movie_Title);
            $sheet->setCellValue('B' . $row, $statistic->Genre);
            $sheet->setCellValue('C' . $row, $statistic->Total_Tickets_Sold);
            $sheet->setCellValue('D' . $row, number_format($statistic->Total_Sales_Value, 2));
            $sheet->setCellValue('E' . $row, $statistic->Total_Screenings);
            $sheet->setCellValue('F' . $row, number_format($statistic->Occupancy_Rate, 2) . '%');
            $row++;
        }

        // Write the file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'movie_statistics.xlsx';
        $filePath = storage_path('app/public/' . $fileName);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function exportScreeningsStatistics(Request $request)
    {
        $filterByGenre = $request->input('genre');
        $filterByTheater = $request->input('theater');
        $filterByStartDate = $request->input('start_date');
        $filterByEndDate = $request->input('end_date');

        // Fetch data
        $screenings = Screening::with(['movie.genre', 'theater.seats', 'tickets'])
            ->when($filterByGenre, function ($query) use ($filterByGenre) {
                $query->whereHas('movie', function ($query) use ($filterByGenre) {
                    $query->where('genre_code', $filterByGenre);
                });
            })
            ->when($filterByTheater, function ($query) use ($filterByTheater) {
                $query->where('theater_id', $filterByTheater);
            })
            ->when($filterByStartDate, function ($query) use ($filterByStartDate) {
                $query->where('date', '>=', $filterByStartDate);
            })
            ->when($filterByEndDate, function ($query) use ($filterByEndDate) {
                $query->where('date', '<=', $filterByEndDate);
            })
            ->get();

        $statistics = $screenings->map(function ($screening) {
            $totalSalesValue = $screening->tickets->sum('price');
            $totalTicketsSold = $screening->tickets->count();
            $totalSeats = $screening->theater ? $screening->theater->seats->count() : 0;

            $occupancyRate = $totalSeats > 0
                ? ($totalTicketsSold / $totalSeats) * 100
                : 0;

            return (object)[
                'Screening_ID' => $screening->id,
                'Movie_Title' => optional($screening->movie)->title,
                'Genre' => optional($screening->movie->genre)->name,
                'Theater' => optional($screening->theater)->name,
                'Total_Sales_Value' => $totalSalesValue,
                'Occupancy_Rate' => round($occupancyRate, 2)
            ];
        });

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'Screening ID');
        $sheet->setCellValue('B1', 'Movie');
        $sheet->setCellValue('C1', 'Genre');
        $sheet->setCellValue('D1', 'Theater');
        $sheet->setCellValue('E1', 'Total Sales');
        $sheet->setCellValue('F1', 'Occupancy Rate (%)');

        // Populate the data
        $row = 2;
        foreach ($statistics as $statistic) {
            $sheet->setCellValue('A' . $row, $statistic->Screening_ID);
            $sheet->setCellValue('B' . $row, $statistic->Movie_Title);
            $sheet->setCellValue('C' . $row, $statistic->Genre);
            $sheet->setCellValue('D' . $row, $statistic->Theater);
            $sheet->setCellValue('E' . $row, number_format($statistic->Total_Sales_Value, 2));
            $sheet->setCellValue('F' . $row, number_format($statistic->Occupancy_Rate, 2) . '%');
            $row++;
        }

        // Write the file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'screening_statistics.xlsx';
        $filePath = storage_path('app/public/' . $fileName);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function exportCustomerStatistics(Request $request)
    {
        $filterByGenre = $request->input('genre');
        $filterByTheater = $request->input('theater');
        $filterByStartDate = $request->input('start_date');
        $filterByEndDate = $request->input('end_date');

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'Customer Name');
        $sheet->setCellValue('B1', 'Customer Email');
        $sheet->setCellValue('C1', 'Tickets Sold');
        $sheet->setCellValue('D1', 'Total Sales');

        // Prepare the query with filters
        $query = Purchase::with(['tickets.screening.movie.genre', 'tickets.screening.theater'])
            ->when($filterByGenre, function ($query) use ($filterByGenre) {
                $query->whereHas('tickets.screening.movie', function ($query) use ($filterByGenre) {
                    $query->where('genre_code', $filterByGenre);
                });
            })
            ->when($filterByTheater, function ($query) use ($filterByTheater) {
                $query->whereHas('tickets.screening', function ($query) use ($filterByTheater) {
                    $query->where('theater_id', $filterByTheater);
                });
            })
            ->when($filterByStartDate, function ($query) use ($filterByStartDate) {
                $query->whereHas('tickets.screening', function ($query) use ($filterByStartDate) {
                    $query->where('date', '>=', $filterByStartDate);
                });
            })
            ->when($filterByEndDate, function ($query) use ($filterByEndDate) {
                $query->whereHas('tickets.screening', function ($query) use ($filterByEndDate) {
                    $query->where('date', '<=', $filterByEndDate);
                });
            });

        // Fetch data in chunks
        $row = 2;
        $query->chunk(1000, function ($purchases) use (&$sheet, &$row) {
            foreach ($purchases as $purchase) {
                $totalSalesValue = $purchase->tickets->sum('price');
                $totalTicketsSold = $purchase->tickets->count();

                $sheet->setCellValue('A' . $row, $purchase->customer_name);
                $sheet->setCellValue('B' . $row, $purchase->customer_email);
                $sheet->setCellValue('C' . $row, $totalTicketsSold);
                $sheet->setCellValue('D' . $row, number_format($totalSalesValue, 2));
                $row++;
            }
        });

        // Write the file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'customer_statistics.xlsx';
        $filePath = storage_path('app/public/' . $fileName);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

}
