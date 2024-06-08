@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex md:flex-row flex-col space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="name" label="Name"
                       :readonly="$readonly"
                       value="{{ old('name', $theater->name)  }}"
                       required="true"/>
        <x-field.input name="rows" label="Rows"
                       required="true"
                       :readonly="$readonly"
                       value="{{ old('rows', $theater->seats->pluck('row')->unique()->count())}}"/>
        <x-field.input name="cols" label="Seats per Row"
                       required="true"
                       :readonly="$readonly"
                       value="{{ old('cols', $theater->seats->pluck('seat_number')->unique()->count())}}"/>
    </div>
    <div>
        <x-field.image
            name="photo_filename"
            label="Theather Photo"
            width="md"
            :readonly="$readonly"
            deleteTitle="Remove Poster"
            :deleteAllow="($mode == 'edit') && ($theater->poster_filename)"
            deleteForm="form_to_delete_image"
            :imageUrl="$theater->getPhoto()"/>
    </div>
</div>
