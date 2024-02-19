<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 (Page not found)</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        .container {
            display: grid;
            height: 100vh;
            align-content: center;
            justify-content: center;
            text-align: center;

            & a {
                text-decoration: none;
                font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                font-weight: bold;
                background-color: #E6583A;
                padding: 10px;
                color: #FFF;
                border-radius: 10px;
                box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 50px;
                cursor: pointer;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <img src="https://media.giphy.com/media/8L0Pky6C83SzkzU55a/giphy.gif?cid=ecf05e47vk0nwn8hgj750nn76yywmhrp809f41gzjibr6tbi&ep=v1_gifs_search&rid=giphy.gif&ct=g" height="400">
        <a onclick="history.back()">Back to page</a>
    </div>
</body>
</html>