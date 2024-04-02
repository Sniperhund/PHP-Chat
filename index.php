<!DOCTYPE html>
<html>
    <head>
        <title>PHP Test</title>
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="cookie.js"></script>
        <script defer>
            $(document).ready(function() {
                if (getCookie("username"))
                    window.location.replace("/Chat/username.php")

                function fetchNewMessages() {
                    $.ajax({
                        url: 'getMessages.php?channel=' + getCookie("channel"),
                        type: 'GET',
                        success: function(data) {
                            $('#messages').html(data)
                        }
                    })
                }

                function fetchNewChannels() {
                    $.ajax({
                        url: 'getChannels.php',
                        type: 'GET',
                        success: function(data) {
                            $('.channel-container').html(data)

                            $(".channel-container p").click((e) => {
                                setCookie("channel", e.target.outerText, 365)

                                $('#channel-name').html(getCookie("channel"))
                                $('#channel').val(getCookie("channel"))

                                // Add a Loading... thing when in production (maybe) but in development it's too fast
                                // $('#messages').html("<h1>Loading...</h1>")

                                fetchNewMessages()
                            })
                        }
                    })
                }

                fetchNewMessages()
                fetchNewChannels()

                setInterval(fetchNewMessages, 1000)
                setInterval(fetchNewChannels, 1000)

                $('#channel-name').html(getCookie("channel"))
                $('#channel').val(getCookie("channel"))
                $('#username').val(getCookie("username"))
            })
        </script>
    </head>
    <body>
        <?php
            require "database.php";

            $GLOBALS["conn"] = connect();
        ?>

        <main>
            <div class="channel-container"></div>

            <div class="chat-container">
                <h1 id="channel-name"></h1>

                <section id="messages">
                </section>

                <div class="spacer"></div>

                <iframe name="content" style="display: none;"></iframe>

                <form action="insert.php" method="post" target="content" class="input">
                    <input type="hidden" id="username" name="username">
                    <input type="hidden" id="channel" name="channel">
                    <input type="text" id="message" name="message" required><br>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </main>
    </body>
</html>