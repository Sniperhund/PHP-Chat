<!DOCTYPE html>
<html>
    <head>
        <title>PHP Test</title>
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="cookie.js"></script>
        <script>
            $(document).ready(function() {
                if (getCookie("username"))
                    window.location.replace("/Chat/index.php")

                $("#button").click(() => {
                    let username = $("#username").val()

                    if (username.length < 8)
                        alert("Your username must be over 8 characters")
                    if (username.length > 16)
                        alert("Your username must be under 8 characters")

                    setCookie("username", username, 365)
                    setCookie("channel", "Default", 365)
                    window.location.replace("/Chat/index.php")
                })
            })
        </script>
    </head>
    <body>
        <h1>Please set your username :)</h1>
        <input type="text" id="username" />
        <button id="button">Submit username</button>
    </body>
</html>