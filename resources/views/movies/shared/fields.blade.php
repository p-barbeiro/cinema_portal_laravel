@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex md:flex-row flex-col space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="title" label="Title"
                       :readonly="$readonly"
                       value="{{ old('title', $movie->title)  }}"
                       required="true"/>
        <x-field.select name="genre_code" label="Genre"
                        :readonly="$readonly"
                        :options="\App\Models\Genre::all()->pluck('name', 'code')->toArray()"
                        value="{{ old('genre_code', $movie->genre_code) }}"
                        required="true"/>
        <x-field.input name="year" label="Year"
                       :readonly="$readonly"
                       required="true"
                       value="{{ old('year', $movie->year) }}"/>
        <x-field.text-area name="synopsis" label="Synopsis"
                           :readonly="$readonly"
                           required="true"
                           value="{{ old('synopsis', $movie->synopsis) }}"/>
        @if($mode != 'show')
            <x-field.input name="trailer_url" label="Trailer URL"
                           :readonly="$readonly"
                           value="{{ old('trailer_url', $movie->trailer_url) }}"/>
        @endif

    </div>
    <div>
        <x-field.image
            name="poster_filename"
            label="Poster"
            width="md"
            :readonly="$readonly"
            deleteTitle="Remove Poster"
            :deleteAllow="($mode == 'edit') && ($movie->poster_filename)"
            deleteForm="form_to_delete_image"
            :imageUrl="$movie->getPoster()"/>
        @if($mode != 'edit')

            @if($movie->trailer_url)

                <x-button
                    href="{{ $movie->trailer_url }}"
                    class="mt-6"
                    text="Watch Trailer"
                    type="info"/>
            @endif

        @endif
    </div>

</div>
