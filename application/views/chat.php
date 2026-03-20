<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat Room</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        #chatBox {
            height: 450px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            background: #f8f9fa;
        }
        .msg-bubble {
            margin-bottom: 10px;
        }
        .msg-bubble .sender {
            font-weight: 600;
            font-size: 13px;
            color: #495057;
        }
        .msg-bubble .text {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 8px 12px;
            display: inline-block;
            max-width: 75%;
        }
        .msg-bubble.mine .text {
            background: #007bff;
            color: #fff;
            border-color: #007bff;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-primary">
    <span class="navbar-brand">Chat Room</span>
    <div>
        <span class="text-white mr-3">Hello, <?= htmlspecialchars($user_name) ?></span>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <div id="chatBox" class="mb-3"></div>

    <div class="input-group">
        <input type="text" id="messageInput" class="form-control"
               placeholder="Type your message..." autocomplete="off">
        <div class="input-group-append">
            <button class="btn btn-primary" id="sendBtn">Send</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
var lastId    = 0;
var myName    = '<?= $user_name ?>';
var baseUrl   = '<?= base_url() ?>';

// send messages
$('#sendBtn').click(sendMessage);

$('#messageInput').keypress(function(e) {
    if (e.which === 13) sendMessage();
});

function sendMessage() {
    var msg = $('#messageInput').val().trim();
    if (msg === '') return;

    $.ajax({
        url: baseUrl + 'chat/send',
        type: 'POST',
        data: { message: msg },
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success') {
                $('#messageInput').val('');
                fetchMessages();
            }
        }
    });
}

// fetch messages
function fetchMessages() {
    $.ajax({
        url: baseUrl + 'chat/fetch',
        type: 'POST',
        data: { last_id: lastId },
        dataType: 'json',
        success: function(messages) {
            if (messages.length > 0) {
                $.each(messages, function(i, msg) {
                    var isMe = (msg.sender_name === myName);
                    var align = isMe ? 'text-right mine' : '';

                    var bubble = '<div class="msg-bubble ' + align + '">' +
                        '<div class="sender">' + (isMe ? 'You' : msg.sender_name) + '</div>' +
                        '<div class="text">' + escapeHtml(msg.message) + '</div>' +
                        '</div>';

                    $('#chatBox').append(bubble);
                    lastId = msg.id; 
                });

                var box = document.getElementById('chatBox');
                box.scrollTop = box.scrollHeight;
            }
        }
    });
}

function escapeHtml(text) {
    return $('<div>').text(text).html();
}

fetchMessages(); 
setInterval(fetchMessages, 2000);
</script>
</body>
</html>