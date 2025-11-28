@extends('layouts.app')
@section('content')
    <div class="bg-gray-50 relative w-full overflow-x-hidden">
        <!-- Shared Background Layer -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Top Shape -->
            <div aria-hidden="true"
                class="absolute inset-x-0 -top-40 transform-gpu overflow-hidden blur-3xl sm:-top-80 animate-float">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                    class="relative left-[calc(50%-11rem)] aspect-1155/678 w-[36.125rem] -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#19328f] to-[#19328f] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]">
                </div>
            </div>

            <!-- Bottom Shape -->
            <div aria-hidden="true"
                class="absolute inset-x-0 top-[calc(100%-13rem)] transform-gpu blur-3xl sm:top-[calc(100%-30rem)] animate-float animation-delay-500">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                    class="relative left-[calc(50%+3rem)] aspect-1155/678 w-[36.125rem] -translate-x-1/2 bg-linear-to-tr from-[#19328f] to-[#599cff] opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]">
                </div>
            </div>

            <!-- Middle Left Shape -->
            <div aria-hidden="true"
                class="absolute top-1/2 left-0 -translate-y-1/2 transform-gpu blur-3xl animate-float animation-delay-1000">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                    class="relative left-[calc(50%-15rem)] aspect-1155/678 w-[36.125rem] -translate-x-1/2 rotate-180 bg-linear-to-tr from-[#19328f] to-[#599cff] opacity-20 sm:left-[calc(50%-35rem)] sm:w-[72.1875rem]">
                </div>
            </div>

            <!-- Bottom Right Shape -->
            <div aria-hidden="true"
                class="absolute bottom-0 right-0 transform-gpu blur-3xl animate-float animation-delay-2000">
                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                    class="relative left-[calc(50%+10rem)] aspect-1155/678 w-[36.125rem] -translate-x-1/2 rotate-90 bg-linear-to-tr from-[#599cff] to-[#19328f] opacity-20 sm:left-[calc(50%+40rem)] sm:w-[72.1875rem]">
                </div>
            </div>
        </div>

        <!-- Content Layer -->
        <div class="relative z-10">
            <!-- Welcome Section -->
            <div class="px-4 sm:px-6 lg:px-8 min-h-screen flex flex-col justify-center items-center">
                <div class="mx-auto max-w-4xl w-full py-12 sm:py-20">
                    <!-- Glassmorphism Card -->
                    <div class="bg-white/40 backdrop-blur-md border border-white/50 shadow-2xl shadow-blue-900/10 rounded-3xl p-8 sm:p-12 md:p-16 text-center animate-fade-in-up">
                        
                        <div class="flex justify-center mb-8 sm:mb-10 animate-float">
                            <img src="{{ asset('images/unib-logo.webp') }}" alt="UNIB Logo" class="h-24 sm:h-32 md:h-40 w-auto drop-shadow-xl" />
                        </div>
                        
                        <div class="space-y-2 sm:space-y-4">
                            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-blue-950 animate-fade-in-up animation-delay-100 opacity-0">
                                Selamat datang di
                            </h1>
                            <p class="text-5xl sm:text-7xl lg:text-8xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-blue-700 to-blue-500 animate-fade-in-up animation-delay-200 opacity-0 pb-2">
                                SI-ELFA
                            </p>
                            <p class="mt-6 text-lg sm:text-xl text-gray-600 leading-relaxed max-w-2xl mx-auto animate-fade-in-up animation-delay-300 opacity-0 font-medium">
                                SI-ELFA adalah platform yang dirancang untuk memfasilitasi evaluasi dan peningkatan kualitas di lingkungan fakultas.
                            </p>
                        </div>

                        <div class="mt-10 sm:mt-12 animate-zoom-in animation-delay-500 opacity-0">
                            <a href="#survei-aktif" id="scrollToSurvey"
                                class="group inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-blue-500 rounded-2xl hover:scale-105 hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i data-lucide="home" class="me-2 w-6 h-6 group-hover:-translate-y-1 transition-transform duration-300"></i>
                                Klik Disini Untuk Memulai
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active surveys section -->
            <section id="survei-aktif" class="pb-20 pt-10">
                <div class="container mx-auto px-4 sm:px-6">
                    
                    <!-- Header Section -->
                    <div class="max-w-3xl mx-auto text-center mb-12 animate-fade-in-down">
                        <span class="inline-block py-1 px-3 rounded-full bg-blue-50 text-blue-600 text-sm font-semibold mb-4 border border-blue-100">
                            Survei Terbaru
                        </span>
                        <h3 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-4">
                            Survei Aktif
                        </h3>
                        <p class="text-lg text-gray-600 leading-relaxed">
                            Partisipasi Anda sangat berarti. Pilih survei di bawah ini dan bantu kami menjadi lebih baik.
                        </p>
                    </div>

                    <!-- Search & Filter Card -->
                    <div class="max-w-4xl mx-auto mb-16 animate-zoom-in animation-delay-200 opacity-0">
                        <div class="bg-white rounded-2xl shadow-xl shadow-blue-900/5 border border-gray-100 p-2 sm:p-3">
                            <form method="GET" action="{{ url('/') }}" class="flex flex-col md:flex-row gap-2">
                                <!-- Search Input -->
                                <div class="relative flex-grow group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                                    </div>
                                    <input type="text" id="cariSurvei" name="cariSurvei" placeholder="Cari judul survei..."
                                        value="{{ request('cariSurvei') }}"
                                        class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border-transparent focus:bg-white border-2 focus:border-blue-500 rounded-xl focus:ring-0 transition-all duration-300 placeholder-gray-400 text-gray-700 font-medium">
                                </div>

                                <!-- Filter Target -->
                                <div class="relative md:w-64 group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-filter text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                                    </div>
                                    <select name="target"
                                        class="w-full pl-11 pr-10 py-3.5 bg-gray-50 border-transparent focus:bg-white border-2 focus:border-blue-500 rounded-xl focus:ring-0 transition-all duration-300 text-gray-700 font-medium appearance-none cursor-pointer">
                                        <option value="">Semua Target</option>
                                        <option value="mahasiswa" {{ request('target') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                        <option value="dosen" {{ request('target') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                        <option value="staff" {{ request('target') == 'staff' ? 'selected' : '' }}>Staff</option>
                                        <option value="alumni" {{ request('target') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                                        <option value="stakeholder" {{ request('target') == 'stakeholder' ? 'selected' : '' }}>Stakeholder</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                    class="px-8 py-3.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 active:bg-blue-800 transition-all duration-300 shadow-lg shadow-blue-600/20 hover:shadow-blue-600/30 transform hover:-translate-y-0.5">
                                    Cari
                                </button>
                                
                                @if (request('cariSurvei') || request('target'))
                                    <a href="{{ url('/') }}"
                                        class="px-4 py-3.5 flex items-center justify-center bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-300" title="Reset Filter">
                                        <i class="fas fa-redo"></i>
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>

                    <!-- Surveys Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        @foreach ($kuesioner as $item)
                            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-blue-900/5 transition-all duration-300 hover:-translate-y-1 overflow-hidden flex flex-col sm:flex-row animate-fade-in-up opacity-0"
                                style="animation-delay: {{ $loop->index * 150 }}ms">
                                
                                <!-- Icon Section -->
                                <div class="sm:w-40 bg-gradient-to-br from-blue-50 to-white flex items-center justify-center p-8 sm:p-0 relative overflow-hidden">
                                    <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))]"></div>
                                    <i class="{{ $item->icon }} text-blue-600 text-5xl sm:text-6xl relative z-10 transform group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 ease-out"></i>
                                </div>

                                <!-- Content Section -->
                                <div class="flex-1 p-6 sm:p-8 flex flex-col">
                                    <div class="flex justify-between items-start gap-4 mb-4">
                                        <h4 class="text-xl font-bold text-gray-900 leading-tight group-hover:text-blue-600 transition-colors duration-300 line-clamp-2">
                                            {{ $item->judul }}
                                        </h4>
                                        <span @class([
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 ring-inset',
                                            'bg-green-50 text-green-700 ring-green-600/20' => $item->status_aktif,
                                            'bg-gray-50 text-gray-600 ring-gray-500/10' => !$item->status_aktif,
                                        ])>
                                            <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $item->status_aktif ? 'bg-green-600' : 'bg-gray-500' }}"></span>
                                            {{ $item->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </div>

                                    <p class="text-gray-600 text-sm leading-relaxed mb-6 line-clamp-2 flex-grow">
                                        {{ Str::limit($item->deskripsi, 120) }}
                                    </p>

                                    <div class="flex items-center justify-between pt-6 border-t border-gray-50 mt-auto">
                                        <div class="flex items-center text-gray-500 text-xs font-medium">
                                            <i class="far fa-calendar-alt mr-2 text-blue-400"></i>
                                            <span>Berakhir: {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</span>
                                        </div>
                                        
                                        <a href="{{ route('survei.profil', $item->id) }}"
                                            class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-blue-200 text-blue-600 text-sm font-semibold rounded-lg hover:bg-blue-600 hover:text-white hover:border-transparent transition-all duration-300 group-hover:shadow-md">
                                            Isi Survei
                                            <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($kuesioner instanceof \Illuminate\Pagination\AbstractPaginator)
                        <div class="mt-16 flex justify-center">
                            {{ $kuesioner->links('pagination.custom') }}
                        </div>
                    @endif
                </div>
            </section>
            @include('layouts.footer')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll for the start button
            document.getElementById('scrollToSurvey').addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('survei-aktif').scrollIntoView({
                    behavior: 'smooth'
                });
            });

            // Auto-scroll if filter params exist
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('cariSurvei') || urlParams.has('target')) {
                const element = document.getElementById('survei-aktif');
                if (element) {
                    element.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            }
        });
    </script>
@endsection