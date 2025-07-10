<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Person Profiles</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 900px; margin: 30px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px #0001; }
        h1 { text-align: center; margin-bottom: 30px; }
        .profiles { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .profile { background: #fafafa; border-radius: 8px; box-shadow: 0 1px 4px #0002; padding: 20px; width: 250px; display: flex; flex-direction: column; align-items: center; }
        .profile img { border-radius: 50%; width: 70px; height: 70px; object-fit: cover; margin-bottom: 10px; }
        .profile h2 { margin: 10px 0 5px 0; font-size: 1.2em; }
        .profile .email { color: #555; font-size: 0.95em; margin-bottom: 10px; }
        .profile .resume { font-size: 0.98em; color: #333; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Person Profiles</h1>
        <div class="profiles">
            @foreach($people as $person)
                <div class="profile">
                    <img src="{{ $person['picture'] }}" alt="{{ $person['first_name'] }} {{ $person['last_name'] }}">
                    <h2>{{ $person['first_name'] }} {{ $person['last_name'] }}</h2>
                    <div class="email">{{ $person['email'] }}</div>
                    <div class="resume">{{ $person['resume'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html> 