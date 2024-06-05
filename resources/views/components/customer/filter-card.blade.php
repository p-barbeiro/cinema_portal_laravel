<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-row space-y-2">
                    <x-field.input name="search" label="{{$searchPlaceholder}}" class="grow"
                                   value="{{ $search }}"/>
                <div class="mx-4 pt-4">
                    <x-button element="submit" type="dark" text="Filter"/>
                </div>
                <div class="me-4 pt-4">
                    <x-button element="a" type="light" text="Reset" :href="$resetUrl"/>
                </div>
            </div>
        </div>
    </form>
</div>
