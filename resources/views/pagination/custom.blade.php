@if ($paginator->hasPages())
    <div class="relative rounded-md bg-white px-4 py-3 sm:px-6">
        {{-- Mobile: ringkas, tampil Prev dan Next, plus ringkasan --}}
        <div class="sm:hidden">
            <div class="flex items-center justify-between gap-4">
                {{-- Tombol Sebelumnya --}}
                @if ($paginator->onFirstPage())
                    <span
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-400 cursor-default">
                        ‹
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        ‹
                    </a>
                @endif

                {{-- Ringkasan --}}
                <span class="text-sm text-gray-700">
                    Menampilkan
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    hingga
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    dari
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    hasil
                </span>

                {{-- Tombol Berikutnya --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        ›
                    </a>
                @else
                    <span
                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-400 cursor-default">
                        ›
                    </span>
                @endif
            </div>
        </div>

        {{-- Desktop: lengkap, ada angka halaman dan ringkasan --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between gap-4">
            <p class="text-sm text-gray-700">
                Menampilkan
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                hingga
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                dari
                <span class="font-medium">{{ $paginator->total() }}</span>
                hasil
            </p>

            <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-xs">
                {{-- Prev --}}
                @if ($paginator->onFirstPage())
                    <span
                        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-300 border border-gray-300 cursor-default">‹</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 border border-gray-300 hover:bg-gray-50">‹</a>
                @endif

                {{-- Numbers --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span
                            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300">...</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page"
                                    class="relative inline-flex items-center bg-deep-sapphire-600 px-4 py-2 text-sm font-semibold text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 border border-gray-300 hover:bg-gray-50">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 border border-gray-300 hover:bg-gray-50">›</a>
                @else
                    <span
                        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-300 border border-gray-300 cursor-default">›</span>
                @endif
            </nav>
        </div>
    </div>
@endif