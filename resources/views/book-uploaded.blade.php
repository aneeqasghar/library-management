<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Uploaded</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', sans-serif; color: #111827; }
        .container { max-width: 560px; margin: 24px auto; padding: 24px; border: 1px solid #e5e7eb; border-radius: 8px; }
        h1 { font-size: 18px; margin: 0 0 12px; }
        p { margin: 8px 0; }
        .muted { color: #6b7280; font-size: 14px; }
    </style>
    
</head>
<body>
    <div class="container">
        <h1>New Book Uploaded</h1>
        <p>A new book has been uploaded to the library.</p>
        <p><strong>Title:</strong> {{ $book->title }}</p>
        <p><strong>Author:</strong> {{ $book->author }}</p>
        <p class="muted">Uploaded at {{ $book->uploaded_at }}</p>
    </div>
</body>
</html>
