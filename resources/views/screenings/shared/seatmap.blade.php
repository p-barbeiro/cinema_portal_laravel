<div class="table mx-auto border dark:bg-gray-500 dark:border-gray-500 rounded-md">
    @foreach ($seatMap as $seats)
        <div class="flex flex-row flex-wrap justify-center">
            @foreach ($seats as $seat)
                <div class="table-cell">
                    @if ($seat['status'] == 'available')
                        <div class="cursor-pointer flex justify-center items-center text-sm m-0.5">
                            <input type="checkbox" id="seat-{{ $seat['label'] }}" name="seats[]" value="{{ $seat['id'] }}" class="hidden">
                            <label for="seat-{{ $seat['label'] }}"
                                   class="dark:border-gray-800 border border-gray-400 text-green-500 cursor-pointer text-xs min-w-4 min-h-4 md:w-6 md:h-6 bg-green-200 hover:bg-orange-200 hover:text-orange-500 flex items-center justify-center rounded">
                                <div class="text-xs hidden md:contents">
                                    {{ $seat['label'] }}
                                </div>
                            </label>
                        </div>

                    @elseif($seat['status'] == 'occupied')
                        <div class="cursor-pointer flex justify-center items-center text-sm m-0.5">
                            <input type="checkbox" id="seat-{{ $seat['label'] }}" name="seats[]" value="{{ $seat['id'] }}" class="hidden" checked disabled>
                            <label for="seat-{{ $seat['label'] }}"
                                   class="dark:border-gray-800 border border-gray-400 bg-red-200 md:w-6 md:h-6 min-w-4 min-h-4 flex items-center justify-center rounded">
                                <div class="text-xs hidden md:contents text-red-500">
                                    {{ $seat['label'] }}
                                </div>
                            </label>
                        </div>
                    @else
                        <div class="cursor-pointer flex justify-center items-center text-sm m-0.5">
                            <input type="checkbox" id="seat-{{ $seat['label'] }}" name="seats[]" value="{{ $seat['id'] }}" class="hidden" checked disabled>
                            <label for="seat-{{ $seat['label'] }}"
                                   class="dark:border-gray-800 border border-gray-400 bg-orange-300 md:w-6 md:h-6 min-w-4 min-h-4 flex items-center justify-center rounded">
                                <div class="text-xs hidden md:contents text-orange-500">
                                    {{ $seat['label'] }}
                                </div>
                            </label>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
    <div class="border border-gray-400 mt-10 mb-2 mx-10 bg-gray-100 uppercase rounded text-sm text-center text-gray-400 dark:border-gray-600 dark:text-gray-600">Screen</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    this.nextElementSibling.classList.remove('bg-green-200', 'hover:bg-orange-200', 'text-green-500');
                    this.nextElementSibling.classList.add('bg-orange-300', 'text-orange-500');
                } else {
                    this.nextElementSibling.classList.remove('bg-orange-300');
                    this.nextElementSibling.classList.add('bg-green-200', 'hover:bg-orange-200');
                }
            });
        });
    });
</script>

