/**
 * Created by rizkadwiu on 3/22/2016.
 */
var username;

$(document).ready(function()
{
    username = $('#username').html();

    $(document).keyup(function(e){
        if (e.keyCode==13)
            sendMessage();
        else
            isTyping();
    });
});

function sendMessage()
{
    var text=$('#text').val();

    if(text.length > 0)
    {
        $.post('',{text: text, username: username}, function()
        {
            $('#chat-window').append('<br><div style="text-align: right">'+text+'</div><br>');
            $('#text').val('');
            notTyping();
        });
    }
}


function isTyping()
{
    $username = Input::get('username');
    $chat = Chat::find(1);
    if  ($chat->user1 == $username)
        $chat->user1_is_typing = true;
    else
        $chat->user2_is_typing = true;
    $chat->save();
}

function notTyping()
{
    $.post('',{username: username});
}