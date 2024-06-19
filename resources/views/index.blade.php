<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>API - Documentation</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style> body { font-family: 'Nunito', sans-serif; } </style>
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="bg-gray-100 text-gray-700">
        <div class="container mx-auto px-4">
            <!-- Title -->
            <div class="flex justify-center mt-5">
                <h2 class="text-green-400 font-mono font-bold text-lg">Post Management Application</h2>
            </div>

            <!-- Intro -->
            <div class="mt-8 text-center">
                <p class="text-gray-600 text-lg">
                    Welcome to my Post Management Application, a showcase of my expertise in developing and documenting RESTful APIs using Laravel. This project leverages Tailwind CSS for styling, providing a clean and responsive user interface. Explore the detailed documentation of each API version below to see how I implement and manage different versions of an API effectively.
                </p>
                <p class="text-gray-600 text-lg mt-4">
                    Additionally, this application demonstrates the integration of various tools and best practices in modern web development, ensuring scalability and maintainability.
                </p>
                <div class="mt-6">
                    <a href="api/documentation/v1" class="inline-block bg-green-400 text-white py-2 px-4 rounded hover:bg-green-500">
                        API Documentation V1
                    </a>
                    <a href="api/documentation/v2" class="inline-block bg-green-400 text-white py-2 px-4 rounded hover:bg-green-500 ml-4">
                        API Documentation V2
                    </a>
                </div>
            </div>

            <!-- Posts -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 my-10 gap-6">
                @foreach($posts as $post)
                <div class="bg-gray-800 text-white p-6 rounded-lg w-full font-mono shadow-md">
                    <div class="mt-4">
                        <p class="text-white">{</p>
                        <div class="ml-4">
                            <p><span class="text-green-400">"id":</span> <span class="text-white">{{ $post->id }}</span>,</p>
                            <p><span class="text-green-400">"post_name":</span> <span class="text-white">{{ $post->title }}</span>,</p>
                            <p><span class="text-green-400">"excerpt":</span> <span class="text-white">{{ $post->excerpt }}</span>,</p>
                            <p><span class="text-green-400">"author":</span> {</p>
                            <div class="ml-5">
                                <p><span class="text-green-400">"name":</span> <span class="text-white">{{ $post->user->name }}</span>,</p>
                                <p><span class="text-green-400">"email":</span> <span class="text-white">{{ $post->user->email }}</span>,</p>
                            </div>
                            <p class="text-green-400">},</p>
                            <p><span class="text-green-400">"created_at":</span> <span class="text-white">{{ $post->published_at }}</span>,</p>
                        </div>
                        <p class="text-white">}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mb-10">
                {{ $posts->links() }}
            </div>
        </div>
    </body>
</html>
