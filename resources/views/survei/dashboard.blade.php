<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>SIELFA</title>
</head>

<body>
    <section class="h-screen flex items-center justify-center landing-pattern">
        <div class="container mx-auto px-15">
            <div class="flex flex-col-reverse md:flex-row items-center justify-between gap-8 h-[75vh]">
                <!-- Left: Text content (aligned center vertically) -->
                <div class="md:w-1/2 w-full flex items-center">
                    <div class="max-w-lg md:text-left text-center">
                        <h1 class="text-8xl font-bold text-deep-sapphire-950">SI-ELFA</h1>
                        <h2 class="text-6xl font-semibold mt-2 text-deep-sapphire-700">Sistem Informasi Evaluasi
                            Fakultas</h2>
                        <h1 class="mt-4 text-1xl font-medium text-deep-sapphire-950">SI-ELFA adalah platform yang
                            dirancang untuk memfasilitasi evaluasi dan peningkatan kualitas di lingkungan fakultas.</h1>
                        <a href="#" id="scrollToSurvey"
                            class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">Isi
                            Survei</a>
                    </div>
                </div>

                <!-- Right: Logo (centered vertically and horizontally in its column) -->
                <div class="md:w-1/2 w-full flex items-center justify-center">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/unib-logo.webp') }}" alt="Logo UNIB"
                            class="w-75 h-75 object-contain">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Active surveys section -->
    <section class="bg-gray-50 py-12">
        <section id="survey-section" class="bg-gray-50 py-12">
            <div class="container mx-auto px-6">
                <div class="max-w-4xl mx-auto text-center mb-8">
                    <h3 class="text-2xl font-semibold text-gray-800">Survey Aktif</h3>
                    <p class="text-gray-600 mt-2">Berikut adalah survei yang sedang aktif. Klik "Isi Survei" untuk
                        memulai.</p>
                </div>
                <form method="GET" action="{{ url('/') }}" class="mt-4 mb-8 max-w-xl mx-auto">
                    <label for="cariSurvei">Cari Survei</label>
                    <div class="flex item-center gap-2">
                        <input type="text" id="cariSurvei" name="cariSurvei" placeholder="Cari judul..."
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
                                <a href="{{ route('survei.profil.tampil', $item->id) }}"
                                    class="ml-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
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
</body>

</html>
