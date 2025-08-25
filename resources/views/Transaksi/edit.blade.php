<!DOCTYPE html>
<html>

<head>
    <title>Edit Transaksi</title>
    <script>
        function hitungTotal() {
            let jumlahs = document.querySelectorAll('input[name="jumlah[]"]');
            let produks = document.querySelectorAll('select[name="produk[]"]');
            let total = 0;

            jumlahs.forEach((jml, i) => {
                let harga = produks[i].selectedOptions[0].getAttribute('data-harga');
                let subtotal = parseInt(harga) * parseInt(jml.value || 0);
                document.getElementById('subtotal-' + i).innerText = subtotal;
                total += subtotal;
            });

            document.getElementById('total_harga').innerText = total;
        }
    </script>
</head>

<body>
    <h1>Edit Transaksi</h1>
    <form method="POST" action="{{ route('transaksi.update', $transaksi->id_transaksi) }}">
        @csrf
        @method('PUT')

        <label>Pembeli:</label>
        <input type="text" name="pembeli" value="{{ $transaksi->pembeli }}" required><br><br>

        <table border="1">
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
            @foreach ($transaksi->details as $i => $detail)
                <tr>
                    <td>
                        <select name="produk[]" onchange="hitungTotal()">
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->id_produk }}" data-harga="{{ $produk->harga }}"
                                    {{ $produk->id_produk == $detail->id_produk ? 'selected' : '' }}>
                                    {{ $produk->nama }} - Rp{{ $produk->harga }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="jumlah[]" value="{{ $detail->jumlah }}" min="1"
                            onchange="hitungTotal()">
                    </td>
                    <td><span id="subtotal-{{ $i }}">{{ $detail->subtotal }}</span></td>
                </tr>
            @endforeach
        </table>

        <h3>Total: Rp <span id="total_harga">{{ $transaksi->total_harga }}</span></h3>
        <button type="submit">Update Transaksi</button>
    </form>
</body>

</html>
