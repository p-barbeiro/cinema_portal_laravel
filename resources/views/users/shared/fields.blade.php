@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
$adminReadonly = $readonly;
    if (!$adminReadonly) {
        if ($mode == 'create') {
            $adminReadonly = Auth::user()?->cannot('create', App\Models\User::class);
        } elseif ($mode == 'edit') {
            $adminReadonly = Auth::user()?->cannot('updateRole', $user);
        } else {
            $adminReadonly = true;
        }
    }
@endphp

<div class="flex flex-wrap space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="name" label="Name" :readonly="$readonly"
                       value="{{ old('name', $user->name?? '') }}"/>
        <x-field.input name="email" type="email" label="Email" :readonly="$readonly"
                       value="{{ old('email', $user->email?? '') }}"/>
        @if($mode == 'create')
            <x-field.input name="password" type="password" label="Password" :readonly="$readonly"/>
            <x-field.input name="password_confirmation" type="password" label="Confirm Password" :readonly="$readonly"/>
        @endif
        <x-field.select name="type" label="Type" :options="['E' => 'EMPLOYEE', 'A' => 'ADMIN']" :readonly="$adminReadonly" value="{{ old('role', $user->type??'') }}"/>

    </div>
    <div class="pb-6">
        <x-field.image
                name="photo_filename"
                label="Photo"
                width="md"
                :readonly="$readonly"
                deleteTitle="Delete Photo"
                :deleteAllow="($mode == 'edit') && ($user->photo_filename??false)"
                deleteForm="form_to_delete_photo"
                :imageUrl="$user->getPhotoFullUrlAttribute()"/>
    </div>
</div>