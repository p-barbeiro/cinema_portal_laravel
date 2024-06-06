<div class="flex justify-between space-x-3">
	<div class="grow flex flex-col space-y-2">
		<div>
			<x-field.select name="movie_id" label="Movie"
							:options="\App\Models\Movie::all()->pluck('title', 'id')->sort()->toArray()"
							required="true"/>
		</div>
		<div class="flex flex-col sm:flex-row ">
			<x-field.select name="theater_id" label="Theater"
							:options="\App\Models\Theater::all()->pluck('name', 'id')->toArray()"
							
							required="true"/>
		</div>
		<div class="flex flex-row space-x-2">
			<x-field.input name="date" type="date" label="Screening Date"/>
			<x-field.input name="date_final" type="date" label="Last Screening Date"/>
			<x-field.input name="start_time" type="time" label="Hour"/>
		</div>
	</div>
</div>
