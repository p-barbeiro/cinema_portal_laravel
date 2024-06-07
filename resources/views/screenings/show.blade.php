@extends('layouts.main')

@section('header-title', $screening->movie->title . " | " . $screening->date . " | " .date('H:i',strtotime($screening->start_time)) . " | " . $screening->theater->name )

@section('main')
	<div class="flex flex-col space-y-6">
		<div class="p-4 sm:p-8 bg-white dark:bg-gray-900 shadow sm:rounded-lg">
			<div class="max-full">
				<section>
					{{--					<div class="flex flex-wrap justify-end items-center gap-4 mb-4">--}}
					{{--												@can('update', \App\Models\Movie::class)--}}
					{{--													<x-button--}}
					{{--															href="{{ route('movies.edit', ['movie' => $movie]) }}"--}}
					{{--															text="Edit"--}}
					{{--															type="secondary"/>--}}
					{{--												@endcan--}}
					{{--												@can('update', \App\Models\Movie::class)--}}
					{{--													<form method="POST" action="{{ route('movies.destroy', ['movie' => $movie]) }}">--}}
					{{--														@csrf--}}
					{{--														@method('DELETE')--}}
					{{--														<x-button--}}
					{{--																element="submit"--}}
					{{--																text="Delete"--}}
					{{--																type="secondary"/>--}}
					{{--													</form>--}}
					{{--												@endcan--}}
					{{--					</div>--}}
					{{--					<hr>--}}
					<div class="space-y-4 -z-10">
						<div class="table mx-auto">
							@foreach ($seatMap as $row => $seats)
								<div class="table-row">
									@foreach ($seats as $seat)
										<div class="table-cell">
											<div class="seat relative">
												@if ($seat['status'] == 'available')
													<div class="seat cursor-pointer bg-green-100 hover:bg-green-500 rounded w-10 h-10 flex justify-center items-center m-1 text-sm">
														@else
															<div disabled class="seat cursor-pointer bg-red-100 rounded w-10 h-10 flex justify-center items-center m-1 text-sm">
																@endif
																{{ $seat['id'] }}
															</div>
													</div>
											</div>
											@endforeach
										</div>
									@endforeach
								</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
@endsection
