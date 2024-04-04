<!DOCTYPE html>
<html>
    <head>
        <title>PHP Test</title>
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="cookie.js"></script>
        <script defer>
            function fetchNewMessages() {
                $.ajax({
                    url: 'api/getMessages.php?channel=' + getCookie("channel"),
                    type: 'GET',
                    success: function(data) {
                        $('#messages').html(data)
                    }
                })
            }

            function fetchNewChannels() {
                $.ajax({
                    url: 'api/getChannels.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#channels').empty()

                        $.each(response, function(index, channel) {
                            $('#channels').append("<p data-channel-id='" + channel.id + "'>" + channel.name + "</p>")
                        });

                        $("#channels p").click(function(e) {
                            setCookie("channel", $(this).data("channel-id"), 365)
                            setCookie("channel-name", $(this).text(), 365)
                            $('#channel-name').html(getCookie("channel-name"))
                            $('#channel').val(getCookie("channel"))
                            fetchNewMessages()
                        })
                    },
                    error: function(xhr, status, error) {
                        console.error(error)
                        $('#channels').html("<p>Error fetching channels</p>")
                    }
                });
            }

            $(document).ready(function() {
                if (!getCookie("access_token"))
                    window.location.replace("/Chat/signup.html")

                fetchNewMessages()
                fetchNewChannels()

                setInterval(fetchNewMessages, 1000)
                setInterval(fetchNewChannels, 1000)

                $('#channel-name').html(getCookie("channel-name"))
                $('#channel').val(getCookie("channel"))
                $('#access-token').val(getCookie("access_token"))

                $("#newChannel").click(() => {
                    $("#createChannelModal").css("display", "flex")
                })

                $(".close").click(() => {
                    $("#createChannelModal").css("display", "none")
                })
            })

            function newChannelCreated(event) {
                event.preventDefault()

                const form = event.target
                const formData = new FormData(form)

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok')
                        }
                        return response.json()
                    })
                    .then(responseJson => {
                        setCookie("channel", responseJson[0].id, 365)
                        setCookie("channel-name", responseJson[0].name, 365)
                        $('#channel-name').html(getCookie("channel-name"))
                        $('#channel').val(getCookie("channel"))
                        fetchNewMessages()
                        fetchNewChannels()
                        $("#createChannelModal").css("display", "none")
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error)
                    })
            }

            function newMessageSent() {
                setTimeout(() => {
                    $("#message").val("")
                    fetchNewMessages()
                }, 10)
            }
        </script>
    </head>
    <body>
        <?php
            require "api/database.php";

            $GLOBALS["conn"] = connect();
        ?>

        <iframe name="content" style="display: none;"></iframe>

        <div id="createChannelModal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Create new channel</h2>
                <form action="api/insertChannel.php" method="post" class="input" onsubmit="return newChannelCreated(event)">
                    <input type="text" id="name" name="name" required><br>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>

        <main>
            <div class="channel-container">
                <section id="channels"></section>

                <div class="spacer"></div>

                <button id="newChannel">Create new channel</button>
            </div>

            <div class="chat-container">
                <h1 id="channel-name"></h1>

                <section id="messages"></section>

                <div class="spacer"></div>

                <form action="api/insertMessage.php" method="post" target="content" class="input" onsubmit="newMessageSent()">
                    <input type="hidden" id="access-token" name="access-token">
                    <input type="hidden" id="channel" name="channel">
                    <input type="text" id="message" name="message" required><br>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </main>
    </body>
</html>