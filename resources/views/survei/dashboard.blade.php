@extends('layouts.app')
@section('content')
    <div class="bg-gray-50 py-1">
        <div class="relative isolate px-6 pt-14 lg:px-8">
            <div aria-hidden="true"
                class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                    class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#19328f] to-[#19328f] opacity-20 sm:left-[calc(50%-30rem)] sm:w-288.75">
                </div>
            </div>
            <div class="mx-auto max-w-3xl pt-20 pb-32 sm:pt-48 sm:pb-40">
                <div class="flex justify-center mb-10">
                    <img src="{{ asset('images/unib-logo.webp') }}" alt="" class="h-40 w-auto" />
                </div>
                <div class="text-center">
                    <h1 class="text-5xl font-semibold tracking-tight text-balance text-blue-950 sm:text-7xl">Selamat datang di</h1>
                    <p class="text-5xl font-semibold tracking-tight text-balance text-blue-800 sm:text-6xl mt-4">SI-ELFA</p>
                    <p class="mt-8 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8">SI-ELFA adalah platform yang
                        dirancang untuk memfasilitasi evaluasi dan peningkatan kualitas di lingkungan fakultas.
                    </p>
                    <div class="survey-selection mt-10">
                        <a href="#" id="scrollToSurvey" class="start-button">
                            <i data-lucide="home" class="me-2"></i>
                            Klik Disini Untuk Memulai
                        </a>
                    </div>
                </div>
            </div>
            <div aria-hidden="true"
                class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                    class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#19328f] to-[#599cff] opacity-20 sm:left-[calc(50%+36rem)] sm:w-288.75">
                </div>
            </div>
        </div>
    </div>

    <!-- Active surveys section -->
    <section class="bg-gray-50 py-12">
        <section id="survey-section" class="bg-gray-50 py-12">
            <div class="container mx-auto px-6">
                <div class="max-w-4xl mx-auto text-center mb-8">
                    <h3 class="text-4xl font-semibold text-gray-800">Survey Aktif</h3>
                    <p class="text-gray-600 mt-2">Berikut adalah survei yang sedang aktif. Klik "Isi Survei" untuk
                        memulai.</p>
                </div>
                <form method="GET" action="{{ url('/') }}" class="mt-4 mb-8 max-w-xl mx-auto">
                    <div class="flex item-center gap-2">
                        <input type="text" id="cariSurvei" name="cariSurvei" placeholder="Cari judul ..."
                            value="{{ request('cariSurvei') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">Cari</button>
                        @if (request('cariSurvei'))
                            <a href="{{ url('/') }}"
                                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-300">Reset</a>
                        @endif
                    </div>
                </form>

                <!-- Surveys Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($kuesioner as $item)
                        <div class="bg-white shadow-sm rounded-lg p-6 flex flex-col justify-between">
                            <div>
                                <!-- Card -->
                                <div class="flex items-center justify-between">
                                    <!-- Bagian Kiri: Icon + Judul -->
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-blue-100">
                                            <i class="{{ $item->icon }} text-blue-600 text-xl"></i>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-800 leading-tight">
                                            {{ $item->judul }}</h4>
                                    </div>
                                    <span @class([
                                        'text-xs px-2 py-1 rounded-full',
                                        'bg-green-100 text-green-700' => $item->status_aktif,
                                        'bg-gray-100 text-gray-600' => !$item->status_aktif,
                                    ])>
                                        {{ $item->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>

                                <!-- Deskripsi -->
                                <p class="text-gray-600 mt-3">{{ Str::limit($item->deskripsi, 110) }}</p>
                            </div>

                            <!-- Footer Card -->
                            <div class="mt-4 flex items-center justify-between">
                                <small class="text-gray-500">
                                    Batas waktu: {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                </small>
                                <a href="{{ route('survei.profil', $item->id) }}"
                                    class="ml-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 isi-button transition duration-300">
                                    Isi Survei
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($kuesioner instanceof \Illuminate\Pagination\AbstractPaginator)
                    <div class="mt-10 flex justify-center">
                        {{ $kuesioner->links('pagination.custom') }}
                    </div>
                @endif
            </div>
        </section>
    </section>
    @include('layouts.footer')
@endsection