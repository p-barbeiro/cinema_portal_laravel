<div {{ $attributes }}>
    <form method="GET" action="{{ $filterAction }}">
        <div class="flex justify-between space-x-3">
            <div class="grow flex flex-row">
                <div class="flex flex-col sm:flex-row grow sm:space-x-5">
                    <x-field.input name="search" label="{{$searchPlaceholder}}"
                                   value="{{ $search }}"/>
                    <x-field.select name="payment_type" label="Payment Type"
                                    value="{{ $paymentType }}"
                                    :options="$listPayment"/>
                </div>
                <div class="flex flex-col sm:flex-row">
                    <div class="sm:me-4 pt-6 ms-4">
                        <x-button element="submit" type="dark" text="Filter"/>
                    </div>
                    <div class="sm:me-4 pt-7 ms-4 sm:ms-0 sm:pt-6">
                        <x-button element="a" type="light" text="Reset" :href="$resetUrl"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
