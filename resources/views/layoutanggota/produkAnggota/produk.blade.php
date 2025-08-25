<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Saya</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Menambahkan style untuk membatasi teks deskripsi */
        .line-clamp-3 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }
    </style>
</head>

<body class="font-poppins bg-gray-100 text-gray-800">

    <header>
        @include('layoutanggota.a.navbar-anggota')
    </header>

    <main class="pt-16">
        <section class="bg-[#4caf50] text-white text-center py-10 px-4">
            <h1 class="text-4xl font-bold tracking-wider">PRODUK SAYA</h1>
            <p class="mt-2 text-lg">Kelola semua produk yang Anda tawarkan.</p>
        </section>

        <section class="py-16">
            <main class="max-w-6xl mx-auto px-4 mt-6 mb-10 flex-grow">

            </main>
        </section>
    </main>

    @include('layoutanggota.a.footer-anggota')


</body>

</html>
