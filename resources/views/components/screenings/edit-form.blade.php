<div class="flex justify-between space-x-3">
    <div class="grow flex flex-col space-y-2">
        <div>
            <x-field.select name="movie_id" label="Movie"
                            :options="\App\Models\Movie::all()->pluck('title', 'id')->sort()->toArray()"
                            value="{{ old('movie_id', $screening->movie_id ?? '') }}"
                            required="true"/>
        </div>
        <div class="flex flex-col sm:flex-row ">
            <x-field.select name="theater_id" label="Theater"
                            :options="\App\Models\Theater::all()->pluck('name', 'id')->toArray()"
                            value="{{ old('theater_id', $screening->theater_id ?? '') }}"
                            required="true"/>
        </div>
        <div class="flex flex-row space-x-2">
            <x-field.input name="date" type="date" label="Screening Date" value="{{ old('date', $screening->date ?? '') }}"/>
            <x-field.input name="start_time" type="time" label="Hour" value="{{ old('start_time', $screening->start_time ?? '') }}"/>
        </div>
    </div>
</div>
