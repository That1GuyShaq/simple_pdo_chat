<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    
    <title>Document</title>
</head>
<body>
    <div id="wrapper">
            <h1>Welcome <?php session_start(); echo $_SESSION['username']; ?></h1>
        <div class="chat_wrapper">
            <div id="chat"></div>
            
            <form id="messageForm" method="post">
                <textarea name="message" id="message" cols="30" rows="7" class="textarea"></textarea>
            </form>
        </div>
    </div>

    <script>
        setInterval(function(){
            loadChat();
        },1000)

        function loadChat(){
            $.post('handler/message.php?action=getMessages', function(response){
                var scrollpos    = $('#chat').scrollTop(); //Current scroll position
                var scrollpos    = parseInt(scrollpos) + 500 + 20; //Current scroll position plus the height of the div and the top and bottom padding
                var scrollheight = $('#chat').prop('scrollHeight');

                $('#chat').html(response);

                if(scrollpos < scrollheight){

                }else{
                    $('#chat').scrollTop($('#chat').prop('scrollHeight'));
                }
            });
        }
        $('.textarea').keyup(function(e){
            if(e.which == 13){
                $('form').submit();
            }
        });
        $('form').submit(function(){
            var message = $('.textarea').val();
            $.post('handler/message.php?action=sendMessage&message='+message,function(response){
                if(response == 1){
                    $('form')[0].reset();
                    loadChat();
                }
            });
            return false;
        });

    </script>
</body>
</html>