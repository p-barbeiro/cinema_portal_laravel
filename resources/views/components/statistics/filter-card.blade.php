<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-col space-y-2">
                <div class="flex space-x-3">
                    @if($genreShow)
                        <x-field.select name="genre" label="Genre"
                                        value="{{ $genre }}"
                                        :options="$listGenres"/>
                    @endif
                    @if($theaterShow)
                        <x-field.select name="theater" label="Theater"
                                        value="{{ $theater }}"
                                        :options="$listTheaters" class="mb-4"/>
                    @endif
                </div>
                <div class="flex space-x-3">
                    <x-field.input class="md:ms-5" name="date" type="date" value="{{$startDate??'Any Date'}}"
                                   label="Select a Date" placeholder="Any Date"/>
                    <x-field.input class="md:ms-5" name="date" type="date" value="{{$endDate??'Any Date'}}"
                                   label="Select a Date" placeholder="Any Date"/>
                </div>
            </div>
            <div class="grow-0 flex flex-col space-y-3 justify-start">
                <div class="pt-6">
                    <x-button element="submit" type="dark" text="Filter"/>
                </div>
                <div>
                    <x-button element="a" type="light" text="Reset" :href="$resetUrl"/>
                </div>
            </div>
        </div>
    </form>
</div>
