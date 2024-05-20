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
                        window.alert(response);
                        if (response.status != false) {
                            updateChat();
                            $('#input-message').val("");
                            $(".send-text").show();
                            $(".mdi-send").show();
                            $(".spinner-border").hide();
                            scrollChatToBottom();
                        } else {
                            $('#input-message').val("");
                            $(".send-text").show();
                            $(".mdi-send").show();
                            $(".spinner-border").hide();
                            iziToast.warning({
                                title: 'Gagal',
                                message: response.data.message,
                                position: 'bottomCenter'
                            });
                        }
                    }
                });

            });

            function createMessageItem(message, foto, time, name, isMyMessage = false) {
                return `
                <li class="${isMyMessage ? 'right' : ''}">
                    <div class="conversation-list">
                        <p class="${isMyMessage ? 'text-end' : ''}">${name}</p>
                        <div class="d-flex">
                            ${isMyMessage ? '' : `<div class="chat-avatar"><img src="/storage/${foto}" alt="avatar-2"></div>`}
                            <div class="replies flex-grow-1">
                                <div class="ctext-wrap">
                                    <div class="ctext-wrap-content">
                                        <p class="mb-0">${message}</p>
                                    </div>
                                </div>
                            </div>
                            ${isMyMessage ? `<div class="chat-avatar"><img src="/storage/${foto}" alt="avatar-2"></div>` : ''}
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

        });
    </script>
@endpush
