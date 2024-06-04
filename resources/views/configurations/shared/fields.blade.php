@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex md:flex-row flex-col space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="ticket_price" label="Ticket Price"
                       :readonly="$readonly"
                       value="{{ old('ticket_price', $configs->ticket_price)  }}"
                       required="true"/>

        <x-field.input name="registered_customer_ticket_discount" label="Registered Customer Ticket Discount"
                       :readonly="$readonly"
                       value="{{ old('registered_customer_ticket_discount', $configs->registered_customer_ticket_discount)  }}"
                       required="true"/>
    </div>
</div>
