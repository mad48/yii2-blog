<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Yii2 Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body, html {
            height: 100%;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        button:hover {
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="container">
    
    <div>
        <button type="button" class="btn btn-primary btn-lg" onclick="window.location='/frontend/web'">frontend</button>

        <button type="button" class="btn btn-warning btn-lg" onclick="window.location='/backend/web'">backend</button>

    </div>
</div>

</body>
</html>