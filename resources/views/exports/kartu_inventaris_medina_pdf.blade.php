<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kartu Pengecekan Inventaris</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 8px;
            text-align: center;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .notes {
            margin-top: 20px;
            font-size: 12px;
        }

        .signature-box {
            text-align: right;
            margin-top: 30px;
        }
        
    </style>
</head>
<body>
    <div class="title">
        <p>Kartu Pengecekan Inventaris</p>
        <p>Ruangan {{$location->name}}</p>
    </div>
    <br>

    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode Alokasi</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th colspan="12">Pengecekan</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Jan</td>
                <td>Feb</td>
                <td>Mar</td>
                <td>Apr</td>
                <td>Mei</td>
                <td>Jun</td>
                <td>Jul</td>
                <td>Agu</td>
                <td>Sep</td>
                <td>Okt</td>
                <td>Nov</td>
                <td>Des</td>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $index => $inventory)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $inventory['id'] }}</td>
                    <td>{{ $inventory['name'] }}</td>
                    <td>{{ $inventory['category'] }}</td>
                    @for ($i = 0; $i < 12; $i++)
                        <td></td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
        
    </table>

    <div class="notes">
        <strong>Keterangan:</strong><br>
        V (Centang) Bagus <br>
        X (Silang) Rusak / Diperbaiki
    </div>

    <div class="signature-box">
        <p>Garut, .............................................................</p>
        <br><br><br><br><br><br>
        <p>______________________________________</p>
    </div>

</body>
</html>
