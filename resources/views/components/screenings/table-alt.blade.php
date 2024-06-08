<div {{ $attributes }}>
	@foreach ($screenings->groupBy('date') as $date => $screeningByDate)
		<table class="table-auto border-collapse dark:text-gray-200 dark:bg-gray-900 rounded w-full">
			<thead>
			<tr>
				@if(Carbon\Carbon::parse($date) < now()->startOfDay())
					<th colspan="100%"
						class="px-2 py-2 text-xl font-light text-left text-gray-300 bg-gray-100 border dark:border-gray-600 dark:bg-gray-800 dark:text-gray-600">
				@else
					<th colspan="100%"
						class="px-2 py-2 text-xl font-light text-left bg-gray-50 border dark:bg-gray-800 dark:border-gray-600">
						@endif
						{{date('l, F j', strtotime($date))}}
						<span class="text-xs text-right w-full">
							{{date('Y', strtotime($date))}}
						</span>
					</th>
			</tr>
			</thead>

			<tbody>
			@foreach ($screeningByDate->groupBy('theater_id') as $screeningHours)
				@if(Carbon\Carbon::parse($date) < now()->startOfDay())
					<tr class="border border-gray-200 dark:border-gray-700 md:w-full text-gray-400 dark:bg-gray-900 dark:text-gray-700 flex flex-wrap justify-center space-x-2 sm:table-row sm:flex-nowrap">
				@else
					<tr class="border border-gray-200 dark:border-gray-700 md:w-full flex flex-wrap justify-center space-x-2 sm:table-row sm:flex-nowrap">
						@endif
						<td class="px-2 py-2 text-center sm:text-left sm:border border-gray-200 dark:border-gray-700 w-full sm:table-cell sm:w-64">
							Theater: {{$screeningHours[0]->theater->name ?? 'Unknown Theater'}}
						</td>

						<td class="px-2 py-2 text-center font-bold text-xl sm:text-base sm:text-left sm:border border-gray-200 dark:border-gray-700 sm:w-auto w-full">
							<a href="{{route('movies.show', ($screeningHours[0]->movie->id??'#'))}}"
							   class="hover:underline underline-offset-2 text-wrap">
								{{$screeningHours[0]->movie->title ?? 'Unknown Movie'}}
							</a>
						</td>

						@foreach ($screeningHours as $screening)
							@if(Carbon\Carbon::parse($date . $screening->start_time) < now())
								<td class="sm:px-2 py-2 text-center md:w-20 text-gray-400 dark:bg-gray-900 dark:text-gray-700">
									<x-button element="a" type="light2"
											  text="{{date('H:i', strtotime($screening->start_time))}}"
											  class="uppercase"
											  href="{{ route('screenings.show', ['screening' => $screening]) }}"
									/>
									@if($screening->isSoldOut())<p class="text-xs text-gray-300">SOLD OUT</p>
							@endif

							@else
								<td class="sm:px-2 py-2 text-center md:w-20 dark:text-gray-400 underline-offset-2">
									<x-button element="a" type="light"
											  text="{{date('H:i', strtotime($screening->start_time))}}"
											  class="uppercase"
											  href="{{ route('screenings.show', ['screening' => $screening]) }}"
									/>
									@if($screening->isSoldOut())
										<p class="text-xs text-red-800">SOLD OUT</p>
									@endif

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
