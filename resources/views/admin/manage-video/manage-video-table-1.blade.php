<td><img src="{{ $value->image }}" /></td>
<td>
    <video controls>
        <source src="{{ $value->link }}" type="video/mp4">
    </video>
</td>
<td>{{ $value->episode }}</td>
<td>{{ $value->complete ? 'Hoàn' : 'Chua hoàn' }}</td>
