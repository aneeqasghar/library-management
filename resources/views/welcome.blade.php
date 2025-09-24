<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-zinc-950 flex items-center justify-center min-h-screen">
    <div class="bg-zinc-900 shadow-lg rounded-2xl p-8 max-w-md text-center">
        <h1 class="text-3xl font-bold text-white mb-4">
            Library Management System
        </h1>

        <div class="space-y-4">
            <a href="{{ url('/admin') }}" 
               class="block bg-violet-600 text-white py-2 px-4 rounded-lg hover:bg-violet-500 transition">
                Admin Panel
            </a>

            <a href="{{ url('/api') }}" 
               class="block bg-teal-600 text-white py-2 px-4 rounded-lg hover:bg-teal-500 transition">
                User API
            </a>
        </div>
    </div>
</body>
</html>