<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>SIELFA</title>
</head>
<body>
    @foreach ($kuesioner as $kuesioner)
        @if ($kuesioner->icon)
            <h3>Kuesioner {{ $loop->iteration }}</h3>
        @endif

        @if ($kuesioner->icon)
            <p>@class="{{ $kuesioner->deskripsi }}"])</p>
        @endif

        @if ($kuesioner->icon)
            <small>@class="{{ $kuesioner->target_respondent }}"])</small>
        @endif
    @endforeach
</body>
</html>