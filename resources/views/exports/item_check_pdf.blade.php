<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Check History PDF</title>
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
        <p>Riwayat Pengecekan Inventaris</p>
        <p>Ruangan {{$location->name}}</p>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Inventaris</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Dicek Oleh</th>
                <th>Tanggal Pengecekan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itemChecks as $check)
                <tr>
                    <td>{{ $check->inventory->name }}</td>
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
