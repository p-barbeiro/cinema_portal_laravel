<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-row space-y-2">
                <div class="grow">
                    <x-field.input name="name" label="{{$searchPlaceholder}}"
                                   value="{{ $name }}"/>
                </div>

                <div class="pt-4 mx-4">
                    <x-button element="submit" type="dark" text="Filter"/>
                </div>
                <div class="pt-4 me-4">
                    <x-button element="a" type="light" text="Reset" :href="$resetUrl"/>
                </div>
            </div>
        </div>
    </form>
</div>
