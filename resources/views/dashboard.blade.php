@extends('layouts.main')

@section('main')
    <div class="flex flex-col justify-start items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-800">
        <div class="w-full m-5 p-5 overflow-hidden sm:rounded-lg">

            <div>
                <div class="w-full mx-auto">
                    <div class="bg-white shadow dark:bg-gray-900 overflow-hidden sm:rounded-lg">
                        <div class="p-6 text-center text-gray-900 dark:text-gray-100 font-bold">
                            {{ __("You're logged in!") }}
                        </div>

                        <div class="p-6 text-center text-gray-900 dark:text-gray-100">
                            Click
                            <a class="underline underline-offset-2 hover:font-bold"href="{{ route('movies.showcase') }}">here</a> if you are not redirected in <span
                                    id="countdown">5</span> seconds.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    redirect("{{ route('movies.showcase') }}", 5);

    function redirect(page, seconds) {
        var timeleft = seconds;
        setTimeout(function () {
                window.location.href = page; // redirects to the page
            }
            , timeleft * 1000);
        var downloadTimer = setInterval(function () {
                timeleft--;
                document.getElementById("countdown").textContent = timeleft;
                if (timeleft <= 0)
                    clearInterval(downloadTimer);
            }
            , 1000);
    }
</script>
