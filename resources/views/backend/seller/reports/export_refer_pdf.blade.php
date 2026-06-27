<!DOCTYPE html>
<html>
<head>
    <title>{{ $pageTitle }}</title>
    <style>
        body { font-family: sans-serif; font-size:13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $pageTitle }}</h2>
        <p>Vendor: {{ $user->name }} ({{ $user->email }})</p>
        <p>Report Date: {{ date('d-M-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">SL</th>
                <th class="text-left">From User</th>
                <th class="text-left">Description</th>
                <th class="text-right" style="width: 150px;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @forelse ($data as $i => $value)
                @php $total += $value->credit; @endphp
                <tr>
                    <td class="text-center">{{ ++$i }}</td>
                    <td class="text-left">{{ $value->from_user->name ?? 'Unknown' }}</td>
                    <td class="text-left">{{ $value->note }}</td>
                    <td class="text-right">{{ number_format($value->credit, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No Data Available</td>
                </tr>
            @endforelse
        </tbody>
        @if($data->count() > 0)
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total Amount:</th>
                <th class="text-right">{{ number_format($total, 2) }}</th>
            </tr>
        </tfoot>
        @endif
    </table>
</body>
</html>
