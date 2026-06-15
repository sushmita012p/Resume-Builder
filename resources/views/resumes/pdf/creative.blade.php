<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #1e293b; line-height: 1.55; }
    </style>
</head>
<body>
    @include('resumes.templates.creative', ['resume' => $resume])
</body>
</html>
