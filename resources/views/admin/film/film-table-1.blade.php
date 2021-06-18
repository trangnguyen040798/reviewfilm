<td><img src="{{ $value->image }}" /></td>
<td>{{ $value->name }}</td>
<td>{{ $value->year }}</td>
<td>{{ $value->type }}</td>
<td>{{ $value->complete == 0 ? 'Chưa hoàn' : 'Hoàn' }}</td>
<td>{{ $value->user->name }}</td>