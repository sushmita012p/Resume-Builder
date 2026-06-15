<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Georgia, Times New Roman, serif; font-size: 12px; color: #1e293b; line-height: 1.6; }
    </style>
</head>
<body>
    @include('resumes.templates.minimal', ['resume' => $resume])
</body>
</html>
