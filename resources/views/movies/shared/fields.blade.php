@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex md:flex-row flex-col space-x-8">
    <div class="grow mt-6 space-y-4">
        <x-field.input name="title" label="Title"
                       :readonly="$readonly || ($mode == 'edit')"
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
        @if($mode == 'edit')
            <x-field.input name="trailer_url" label="Trailer URL"
                           :readonly="$readonly"
                           value="{{ old('trailer_url', $movie->trailer_url) }}"/>
        @endif

        {{--            <x-field.input name="ECTS" label="Nº ECTS" width="sm" :readonly="$readonly"--}}
        {{--                            value="{{ old('ECTS', $course->ECTS) }}"/>--}}
        {{--        <x-field.input name="contact" label="Contact" :readonly="$readonly"--}}
        {{--                            value="{{ old('contact', $course->contact) }}"/>--}}
        {{--        <x-field.text-area name="objectives" label="Objectives" :readonly="$readonly"--}}
        {{--                            value="{{ old('objectives', $course->objectives) }}"/>--}}
        {{--        <x-field.text-area name="objectives_pt" label="Objectives (Portuguese)"--}}
        {{--                        :readonly="$readonly"--}}
        {{--                        value="{{ old('objectives_pt', $course->objectives_pt) }}"/>--}}
        {{--    </div>--}}
    </div>
    <div>
        <x-field.image
            name="movie_poster"
            label="Poster"
            width="md"
            :readonly="$readonly"
            deleteTitle="Remove Poster"
            :deleteAllow="($mode == 'edit') && ($movie->poster_filename)"
            deleteForm="form_to_delete_photo"
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
