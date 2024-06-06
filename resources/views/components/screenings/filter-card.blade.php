<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-col space-y-2">
                <div>
                    <x-field.input name="movie" label="Search by Movie" class="grow"
                                   value="{{ $title }}"/>
                </div>
                <div class="flex flex-col sm:flex-row ">
                    <x-field.select name="theater" label="Theater"
                                    value="{{ $theater }}"
                                    :options="$listTheaters" class="mb-4"/>
                    
                    <x-field.input class="md:ms-5" name="date" type="date" value="{{$date??'Any Date'}}" label="Select a Date" placeholder="Any Date"/>
                    
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
