<div {{ $attributes }}>
    @foreach ($screenings->groupBy('theater_id') as $screeningTheaters)
        <table class="table-auto border-collapse dark:text-gray-200 rounded w-full">
            <thead>
            <tr>
                <th colspan="100%" class="px-2 py-2 text-xl text-left">
                    Theater: {{$screeningTheaters[0]->theater->name ?? 'Unknown Theater'}}
                    {{--                    {{debug($screeningTheaters[0]->theater->name . ":" . $screeningTheaters[0]->theater->seats->count())}}--}}
                </th>
            </tr>
            </thead>

            <tbody>
            @foreach ($screeningTheaters->groupBy('date') as $date => $screeningDates)
                <tr class="border-b border-b-gray-200 dark:border-b-gray-700">
                @if($loop->last)
                    <tr>
                        @endif
                        <td class="px-2 py-2 text-left w-full">
                            {{date('l, F j', strtotime($date))}}
                        </td>
                        @foreach ($screeningDates as $screening)
                            <td class="px-2 py-2 text-center dark:text-gray-400">
                                @if($screening->isSoldOut())
                                    <a class="font-extrabold text-red-800 line-through"
                                       href="#">{{date('H:i', strtotime($screening->start_time))}}</a>
                                @else
                                    <a class="font-extrabold hover:underline underline-offset-2"
                                       href="#">{{date('H:i', strtotime($screening->start_time))}}</a>
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
