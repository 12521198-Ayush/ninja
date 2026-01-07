<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Scheduled At</th>
            <th>Error</th>
        </tr>
    </thead>
    <tbody>
        @foreach($messages as $key => $message)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $message->contact->name ?? 'N/A' }}</td>
            <td>{{ $message->contact->phone ?? 'N/A' }}</td>
            <td>{{ ucfirst($message->status->value ?? $message->status) }}</td>
            <td>{{ $message->schedule_at ? \Carbon\Carbon::parse($message->schedule_at)->format('d/m/Y H:i:s') : 'N/A' }}</td>
            <td>{{ $message->error ?? '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
