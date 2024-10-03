<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Check History PDF</title>
</head>
<body>
    <h1>Item Check History for {{ $location->name }}</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>DiCek Oleh</th>
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
