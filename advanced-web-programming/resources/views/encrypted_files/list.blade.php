<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encrypted Files</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px #0001; }
        h1 { text-align: center; margin-bottom: 20px; }
        ul { list-style: none; padding: 0; }
        li { background: #fafafa; margin-bottom: 10px; padding: 12px 18px; border-radius: 6px; display: flex; justify-content: space-between; align-items: center; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .empty { text-align: center; color: #888; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Encrypted Files</h1>
        @if(count($files) > 0)
            <ul>
                @foreach($files as $file)
                    <li>
                        {{ $file }}
                        <a href="{{ url('/encrypted/download/' . $file) }}">Download and Decrypt</a>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="empty">No encrypted files found.</div>
        @endif
        <div style="text-align:center; margin-top:20px;">
            <a href="{{ url('/encrypted/upload') }}">Upload New File</a>
        </div>
    </div>
</body>
</html> 