<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-col space-y-2">
                <div>
                    <x-field.input name="title" label="{{$searchPlaceholder}}" class="grow"
                                   value="{{ $title }}"/>
                </div>

                <div class="flex space-x-3">
                    <x-field.select name="genre" label="Genre"
                                    value="{{ $genre }}"
                                    :options="$listGenres"/>

                    @if($yearShow)
                        <x-field.select name="year" label="Year"
                                        value="{{ $year }}"
                                        :options="$listYears"/>
                    @endif

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
