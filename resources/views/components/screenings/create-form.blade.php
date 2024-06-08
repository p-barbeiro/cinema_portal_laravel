<div class="flex justify-between space-x-3">
	<div class="grow flex flex-col space-y-2">
		<div>
			<x-field.select name="movie_id" label="Movie"
							:options="\App\Models\Movie::all()->pluck('title', 'id')->sort()->toArray()"
							value="{{ old('movie_id', $screenings->movie_id) }}"
							required="true"/>
		</div>
		<div class="flex flex-col sm:flex-row ">
			<x-field.select name="theater_id" label="Theater"
							:options="\App\Models\Theater::all()->pluck('name', 'id')->toArray()"
							value="{{ old('theater_id', $screenings->theater_id) }}"
							required="true"/>
		</div>
		<div class="flex flex-row space-x-2">
			<x-field.input name="date" type="date" label="Screening Date" value="{{ old('date', $screenings->date) }}"/>
			<x-field.input name="date_final" type="date" label="Last Date" value="{{ old('date_final', $screenings->date_final) }}"/>
			<x-field.input name="start_time" type="time" label="Hour" value="{{ old('start_time', $screenings->start_time) }}"/>
		</div>
	</div>
</div>
