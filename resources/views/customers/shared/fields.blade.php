@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
    $adminReadonly = $readonly;
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="name" label="Name" :readonly="$readonly" value="{{ old('name', $customer->user->name) }}"/>
        <x-field.input name="email" type="email" label="Email" :readonly="$readonly" value="{{ old('email', $customer->user->email) }}"/>
        <x-field.input name="nif" label="NIF" :readonly="$readonly" value="{{ old('nif', $customer->nif) }}"/>
        <x-field.radiogroup id="payment_type" name="payment_type" label="Payment Method" value="{{ old('payment_type', $customer->payment_type) }}"
                            :options="['VISA'=>'VISA', 'MBWAY' => 'MBWAY','PAYPAL'=>'PAYPAL']" :readonly="$readonly"/>
        <x-field.input name="payment_ref" label="Payment Reference" :readonly="$readonly" value="{{ old('email', $customer->payment_ref) }}"/>
    </div>
    <div class="pb-6">
        <x-field.image
                name="photo_filename"
                label="Photo"
                width="md"
                :readonly="$readonly"
                deleteTitle="Delete Photo"
                :deleteAllow="($mode == 'edit') && ($customer->user->photo_filename)"
                deleteForm="form_to_delete_photo"
                :imageUrl="$customer->user->getPhotoFullUrlAttribute()"/>
    </div>
</div>
