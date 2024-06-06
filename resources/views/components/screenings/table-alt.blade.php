<div {{ $attributes }}>
    @foreach ($screenings->groupBy('date') as $date => $screeningByDate)
        <table class="table-auto border-collapse dark:text-gray-200 rounded w-full">
            <thead>
            <tr>
                @if(Carbon\Carbon::parse($date) < now()->startOfDay())
                    <th colspan="100%" class="px-2 py-2 text-xl text-left text-gray-300 bg-gray-100 border">
                @else
                    <th colspan="100%" class="px-2 py-2 text-xl text-left bg-gray-50 border">
                        @endif
                        {{date('l, F j', strtotime($date))}}
                    </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($screeningByDate->groupBy('movie_id') as $screeningHours)
                @if(Carbon\Carbon::parse($date) < now()->startOfDay())
                    <tr class="border border-gray-200 dark:border-gray-700 w-full text-gray-400 bg-gray-50">
                @else
                    <tr class="border border-gray-200 dark:border-gray-700 w-full">
                        @endif

                        <td class="px-2 py-2 text-left border-r border-r-gray-200 hidden sm:table-cell sm:w-64">
                            Theater: {{$screeningHours[0]->theater->name ?? 'Unknown Theater'}}
                        </td>

                        <td class="px-2 py-2 text-left border-r border-r-gray-200">
                            <a href="{{route('movies.show', $screeningHours[0]->movie->id)}}"
                               class="hover:underline underline-offset-2 text-wrap">
                                {{$screeningHours[0]->movie->title ?? 'Unknown Movie'}}
                            </a>
                        </td>
                        @foreach ($screeningHours as $screening)
                            @if(Carbon\Carbon::parse($date . $screening->start_time) < now())
                                <td class="px-2 py-2 text-center w-20 bg-gray-50 text-gray-400 hover:no-underline dark:text-gray-400 border-r border-r-gray-200 ">
                            @else
                                <td class="px-2 py-2 text-center w-20 dark:text-gray-400 border-r border-r-gray-200  hover:underline underline-offset-2">
                                    @endif
                                    @if($screening->isSoldOut())
                                        <a class="font-extrabold text-red-800 line-through"
                                           href="#">{{date('H:i', strtotime($screening->start_time))}}</a>
                                    @else
                                        <a class="font-extrabold"
                                           href="#">
                                            {{date('H:i', strtotime($screening->start_time))}}
                                        </a>
                                    @endif
                                </td>
                                @endforeach
                    </tr>
                    @endforeach
            </tbody>
        </table>
        <br>
    @endforeach
</div>
