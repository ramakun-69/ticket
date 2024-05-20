@push('js')
    <script>
        $(document).ready(function() {
            // scrollChatToBottom();    

            scrollChatToBottom();

            function scrollChatToBottom() {
                var chatList = $("#replies");
                chatList.animate({
                    scrollTop: chatList[0].scrollHeight
                }, "fast");
            }

            const $inputMessage = $('#input-message');
            const $btnSubmit = $('#btn-submit');
            const $replies = $('#replies');

            $inputMessage.on('input', function() {
                $btnSubmit.prop('disabled', !$inputMessage.val().trim());
            });



            $("#form-reply").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('comment.store') }}",
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $(".send-text").hide();
                        $(".mdi-send").hide();
                        $(".spinner-border").show();
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status != false) {
                            updateChat();
                            $('#input-message').val("");
                            $(".send-text").show();
                            $(".mdi-send").show();
                            $(".spinner-border").hide();
                            scrollChatToBottom();
                        }
                    },
                    statusCode: {
                        500: function(response) {
                            iziToast.error({
                                title: 'Gagal',
                                message: response.responseJSON.data.error,
                                position: 'bottomCenter'
                            });
                            $('#input-message').val("");
                            $(".send-text").show();
                            $(".mdi-send").show();
                            $(".spinner-border").hide();
                        }
                    }
                });

            });

            updateChat();
            var latestMessageTimestamp = 0;

            function updateChat() {
                var ticketId = $('#ticket-id').data('ticket-id');
                console.log(ticketId);
                $.ajax({
                    url: "{{ route('comment.index') }}?ticket_id=" + ticketId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // console.log(reply.is_my_reply);
                        if (data.comment.length > 0) {
                            data.comment.forEach(function(comment) {
                                var date = new Date(comment.created_at);
                                var formattedDate = date.getDate() + '-' +
                                    (date.getMonth() + 1) + '-' +
                                    date.getFullYear() + ' ' +
                                    date.getHours() + ':' +
                                    date.getMinutes() + ':' +
                                    date.getSeconds();
                                if (date.getTime() > latestMessageTimestamp) {
                                    if (comment.is_my_comment) {
                                        addMyReplies(comment.comment,  getPhoto(comment.user.foto),
                                            formattedDate, comment.user.pegawai.name);
                                    } else {
                                        addReplies(comment.comment, getPhoto(comment.user.foto),
                                            formattedDate, comment.user.pegawai.name);
                                    }
                                    latestMessageTimestamp = date.getTime();
                                   
                                }
                            });
                        }

                        scrollChatToBottom();
                    },
                    error: function(error) {
                        console.error('Gagal mengambil pesan: ' + error);
                    }
                });
            }

            function createMessageItem(message, foto, time, name, isMyMessage = false) {
                return `
                <li class="${isMyMessage ? 'right' : ''}">
                    <div class="conversation-list">
                        <p class="${isMyMessage ? 'text-end' : ''}">${name}</p>
                        <div class="d-flex">
                            ${isMyMessage ? '' : `<div class="chat-avatar"><img src="${foto}" alt="avatar-2"></div>`}
                            <div class="replies flex-grow-1">
                                <div class="ctext-wrap">
                                    <div class="ctext-wrap-content">
                                        <p class="mb-0">${message}</p>
                                    </div>
                                </div>
                            </div>
                            ${isMyMessage ? `<div class="chat-avatar"><img src="${foto}" alt="avatar-2"></div>` : ''}
                        </div>
                        <p class="chat-time mb-0"><i class="mdi mdi-clock-outline me-1"></i>${time}</p>
                    </div>
                </li>`;
            }

            function addReplies(message, foto, time, name) {
                $replies.append(createMessageItem(message, foto, time, name));
            }

            function addMyReplies(message, foto, time, name) {
                $replies.append(createMessageItem(message, foto, time, name, true));
            }
           
            function getPhoto(foto) {
                if (foto != null) {
                    return '/storage/'+foto;
                }
                return '/assets/images/users/default.jpg';
            }

        });
    </script>
@endpush
