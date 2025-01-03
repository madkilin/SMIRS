<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Checks Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Item Checks Report</h1>

    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Ruangan</th>
                <th>Kondisi</th>
                <th>Keterangan</th>
                <th>Dicek Oleh</th>
                <th>Tanggal Pengecekan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itemChecks as $check)
                <tr>
                    <td>{{ $check->inventory->name }}</td>
                    <td>{{ $check->inventory->category }}</td>
                    <td>{{ $check->location->name ?? '-' }}</td>
                    <td>{{ ucfirst($check->status) }}</td>
                    <td>{{ $check->description }}</td>
                    <td>{{ $check->user->name }}</td>
                    <td>{{ $check->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
