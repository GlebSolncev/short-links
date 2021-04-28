<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form action="{{ route('short-link.store') }}" method="POST">
    {{ csrf_field() }}
    <label>
        <input type="text" placeholder="short your link" name="link">
    </label>
    <input type="submit" value="Get short link">
</form>
@if(request()->session()->has('newLink'))
    <label>
        Your link: <b>{{ request()->session()->get('newLink') }}</b>
    </label>
@endif

@if(count($errors))
    Fail:
    @foreach($errors->all() as $error)
        <p style="color:red">{{ $error }}</p>
    @endforeach
@endif
<h4>Visible</h4>
<table>
    <tr>
        <th>Short link</th>
        <th>Count</th>
        <th>URL</th>
        <th>Updated</th>
        <th>Created</th>
    </tr>
    @foreach($links->where('active', true) as $link)
        <tr>
            <td>
                <a href="{{ route('short-link.show', $link->endpoint) }}" target="_blank">{{ route('short-link.show', $link->endpoint) }}</a>
            </td>
            <td>
                {{ $link->count }}
            </td>
            <td>
                {{ $link->url }}
            </td>
            <td>
                {{ $link->updated_at->format('d.m H:i') }}
            </td>
            <td>
                {{ $link->created_at->format('d.m H:i') }}
            </td>
            <td>
                <form action="{{ route('short-link.update', $link->endpoint) }}" method="POST">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PUT">
                    <input value="Set visible" type="submit">
                </form>
            </td>

            <td>
                <form action="{{ route('short-link.destroy', $link->endpoint) }}" method="POST">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="DELETE">
                    <input value="Delete" type="submit">
                </form>
            </td>
        </tr>
    @endforeach
</table>

<br /<>
<h4>Invisible</h4>
<table>

    <tr>
        <th>Short link</th>
        <th>Count</th>
        <th>URL</th>
        <th>Updated</th>
        <th>Created</th>
    </tr>
@foreach($links->where('active', false) as $link)
    <tr>
        <td>
            {{ route('short-link.show', $link->endpoint) }}
        </td>
        <td>
            {{ $link->count }}
        </td>
        <td>
            {{ $link->url }}
        </td>
        <td>
            {{ $link->updated_at }}
        </td>
        <td>
            {{ $link->created_at }}
        </td>
        <td>
            <form action="{{ route('short-link.update', $link->endpoint) }}" method="POST">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                <input type="hidden" name="endpoint" value="{{ $link->endpoint }}">
                <input value="Set visible" type="submit">
            </form>
        </td>
        <td>
            <form action="{{ route('short-link.destroy', $link->endpoint) }}" method="POST">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="DELETE">
                <input value="Delete" type="submit">
            </form>
        </td>
    </tr>
    @endforeach
    </table>

</body>
</html>
