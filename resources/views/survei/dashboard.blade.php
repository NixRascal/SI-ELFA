@extends('layouts.app')
@section('content')
    <div class="bg-gray-50">
        <div class="relative isolate px-6 lg:px-8 min-h-screen flex items-center">
            <div aria-hidden="true"
                class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                    class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#19328f] to-[#19328f] opacity-20 sm:left-[calc(50%-30rem)] sm:w-288.75">
                </div>
            </div>
            <div class="mx-auto max-w-3xl w-full py-20">
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
                    <h3 class="text-4xl font-semibold text-gray-800">Survei Aktif</h3>
                    <p class="text-gray-600 mt-2">Berikut adalah survei yang sedang aktif. Klik "Isi Survei" untuk
                        memulai.</p>
                </div>
                <form method="GET" action="{{ url('/') }}" class="mt-4 mb-8 max-w-3xl mx-auto">
                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        <!-- Search Input -->
                        <input type="text" id="cariSurvei" name="cariSurvei" placeholder="Cari judul survei..."
                            value="{{ request('cariSurvei') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <!-- Filter Target -->
                        <select name="target" 
                            class="w-full sm:w-48 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Target</option>
                            <option value="mahasiswa" {{ request('target') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="dosen" {{ request('target') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="staff" {{ request('target') == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="alumni" {{ request('target') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                            <option value="stakeholder" {{ request('target') == 'stakeholder' ? 'selected' : '' }}>Stakeholder</option>
                        </select>
                        
                        <!-- Buttons -->
                        <div class="flex gap-2 w-full sm:w-auto">
                            <button type="submit"
                                class="flex-1 sm:flex-none px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 whitespace-nowrap">
                                <i class="fas fa-search mr-1"></i> Cari
                            </button>
                            @if (request('cariSurvei') || request('target'))
                                <a href="{{ url('/') }}"
                                    class="flex-1 sm:flex-none px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-300 text-center whitespace-nowrap">
                                    <i class="fas fa-redo mr-1"></i> Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                <!-- Surveys Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach ($kuesioner as $item)
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden flex flex-col sm:flex-row">
                            <!-- Sidebar Icon -->
                            <div class="w-full sm:w-32 h-32 sm:h-auto bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <i class="{{ $item->icon }} text-blue-600 text-5xl sm:text-6xl"></i>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 p-4 sm:p-5 flex flex-col justify-between">
                                <div>
                                    <!-- Header -->
                                    <div class="flex flex-col sm:flex-row items-start sm:justify-between gap-2 mb-3">
                                        <h4 class="text-base sm:text-lg font-semibold text-gray-800 leading-tight flex-1">
                                            {{ $item->judul }}
                                        </h4>
                                        <span @class([
                                            'text-xs px-2.5 py-1 rounded-full whitespace-nowrap self-start sm:self-auto flex-shrink-0',
                                            'bg-green-100 text-green-700' => $item->status_aktif,
                                            'bg-gray-100 text-gray-600' => !$item->status_aktif,
                                        ])>
                                            {{ $item->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </div>

                                    <!-- Deskripsi -->
                                    <p class="text-gray-600 text-sm leading-relaxed mb-3 sm:mb-4">{{ Str::limit($item->deskripsi, 100) }}</p>
                                </div>

                                <!-- Footer -->
                                <div class="flex flex-col sm:flex-row items-start sm:items-center sm:justify-between gap-3 pt-3 border-t border-gray-100">
                                    <small class="text-gray-500 text-xs">
                                        Batas waktu: {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                    </small>
                                    <a href="{{ route('survei.profil', $item->id) }}"
                                        class="w-full sm:w-auto text-center inline-block px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition duration-300">
                                        Isi Survei
                                    </a>
                                </div>
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