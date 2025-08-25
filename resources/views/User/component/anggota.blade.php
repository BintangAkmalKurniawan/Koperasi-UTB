<div class="absolute top-[380px] left-0 w-full px-4">
    <div class="mx-10 flex flex-wrap justify-center gap-x-8 gap-y-8 ">

        @forelse ($anggota as $item)
            <a href="{{ route('anggota.show', ['id' => $item->id_user]) }}"
                class="relative bg-white w-[248px] h-[311px] rounded-xl shadow-[14px_14px_34px_14px_rgba(0,0,0,0.18)] flex flex-col items-center justify-between p-5 group
                        transform transition-all duration-300 hover:scale-105 hover:shadow-[20px_20px_40px_14px_rgba(0,0,0,0.25)]">

                <div class="flex-grow flex items-center justify-center">
                    <img src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('icon/akun.png') }}"
                        alt="Foto Profil {{ $item->nama }}" class="w-[130px] h-[130px] rounded-full object-cover" />
                </div>

                <p class="font-bold text-[16px] text-[#15532E] px-3 py-2 text-center">{{ $item->nama }}</p>

                <div class="bg-[#49A84E] w-[193px] h-[43px] gap-2 rounded-md flex items-center justify-center">
                    <img src="/icon/eyes.png" alt="">
                    <span class="text-white font-extrabold text-[20px]">Lihat Detail</span>
                </div>
            </a>
        @empty
            <div class="text-center py-10 text-gray-500 col-span-full">
                <p>Tidak ada data anggota yang tersedia.</p>
            </div>
        @endforelse

    </div>
</div>
