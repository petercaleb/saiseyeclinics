<table>
    <thead>
        <tr>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;"></th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Frame Code</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Gender</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Color</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Shape</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Opening</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Transfered</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $hqFrameStock)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $hqFrameStock->code }}</td>
                <td>{{ $hqFrameStock->gender }}</td>
                <td>{{ $hqFrameStock->frame_color->color }}</td>
                <td>{{ $hqFrameStock->frame_shape->shape }}</td>
                <td>{{ $hqFrameStock->opening }}</td>
                <td>{{ $hqFrameStock->transfered }}</td>
                <td>{{ $hqFrameStock->total }}</td>
            </tr>
        @empty
            
        @endforelse
    </tbody>
</table>