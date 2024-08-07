$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.userlist').click(function() {

        $('#chat-container').html("");
        var getUserId= $(this).attr('data-id');
        receiver_id=getUserId;

        $('.start-chat').hide();
        $('.chat-section').show();

        loadOldChats();

    });

//Saving chat

$('#chat-form').submit(function(e){
    e.preventDefault();

    var message= $('#message').val();

    $.ajax({
        url: '/save-chats',
        type: 'POST',

        data:{sender_id: sender_id, receiver_id:receiver_id, message:message},

        success:function(res){
            if (res.Success){
                $('#message').val('');

                let chat=res.data.message;
                let html=`
                <div class="current-user-chat">
                    <h5>`+chat+`</h5>
                    </div>

                `;
                $('#chat-container').append(html);
            }




            else{
                alert(res.msg)
            }
        }
    });
});




});


//loading old  chats

function loadOldChats(){
    $.ajax({
        url: '/load-chats',
        type: 'POST',
        data: { sender_id: sender_id, receiver_id: receiver_id },
        success: function(res){
            if (res.Success) {
                let chats = res.data;
                let html = "";
                for (let i = 0; i < chats.length; i++) {
                    let addClass = '';

                    if (chats[i].sender_id == sender_id) {
                        addClass = 'current-user-chat';
                    } else {
                        addClass = 'distance-user-chat';
                    }

                    html += `
                        <div class="${addClass}">
                            <h5>${chats[i].message}</h5>
                        </div>
                    `;
                }
                $('#chat-container').append(html);

            } else {
                alert(res.msg);
            }
        }
    });
}

Echo.join('status-update')
    .here((users) => {

        for (let i = 0; i < users.length; i++) {
            if (sender_id != users[i]['id']) {
                $('#' + users[i]['id'] + '-status').removeClass('offline-status')
                $('#' + users[i]['id'] + '-status').addClass('online-status')
                $('#' + users[i]['id'] + '-status').text('online')
            }
        }
    })
    .joining((user) => {

        $('#' + user.id + '-status').removeClass('offline-status')
        $('#' + user.id + '-status').addClass('online-status')
        $('#' + user.id + '-status').text('online')
    })
    .leaving((user) => {

        $('#' + user.id + '-status').addClass('offline-status')
        $('#' + user.id + '-status').removeClass('online-status')
        $('#' + user.id + '-status').text('offline')
    });

Echo.channel('private-broadcast-message').listen('.getChatMessage', (data) => {

    if (sender_id == data.chat.receiver_id && receiver_id == data.chat.sender_id) {
        let html = `
            <div class="distance-user-chat">
                <h5>${data.chat.message}</h5>
            </div>
        `;
        $('#chat-container').append(html);
    }
    console.log(data);
});


// group chat script


$(document).ready(function() {
$("#createGroupForm").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url:'/create-group',
        type: 'POST',
        data: new FormData(this),
       contentType:false,
       cache:false,
       processData: false,
        success: function(res){

            alert(res.msg);
            if(res.Success){
               location.reload();
            }

        }
    });



});


});


function scrollGroupChat(){


    $('#group-chat-container').animate({
        scrollTop: $('#group-chat-container').offset().top+ $('#group-chat-container')[0].scrollheight
    },0);



}
$(document).ready(function(){
    $('.addMember').click(function(){
        var id = $(this).attr('data-id');
        var limit = $(this).attr('data-limit');

        $('#add-group-id').val(id);
        $('#add-limit').val(limit);

        $.ajax({
            url: '/get-members',
            type: 'POST',
            data: { group_id: id },
            success: function(res){

                if(res.Success){
                    var users = res.data;
                    var html = '';

                    for(let i = 0; i < users.length; i++){
                        let isGroupMemberChecked = "";
                        if(users[i]['group_user']!=null){
                            isGroupMemberChecked = "checked";
                        }

                        html+=`
                        <tr>
                        <td>
                        <input type="checkbox" name="members[]" value="`+users[i]['id']+`"`+isGroupMemberChecked+` />

                        </td>

                        <td>

                        `+users[i]['name']+`
                        </td>
                        </tr>
                        `;
                }
                $('.addMembersInTable').html(html);

            }
                else
                {
                    alert(res.msg);
                }
            }
        });
    });

    $('#add-member-form').submit(function(e){
        e.preventDefault();
      var formData =  $(this).serialize();

      $.ajax({
        url:'/add-member',
        type:'POST',
        data: formData,
        success: function(res){

            if(res.Success){
               $('#memberModal').modal('hide');
               $('#add-member-form')[0].reset();
               alert(res.msg);
            }

            else
            {

                $('#add-member-error').text(res.msg);
                setTimeout(function(){
                    $('#add-member-error').text('');
                }, 3000);
            }

        }

    });
});

// delete chat
$(".deleteGroup").click(function() {
    $("#delete-group-id").val($(this).attr('data-id'));
    $("#group-name").text($(this).attr('data-name'));
});
$("#delete-group-form").submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
        url: '/delete-group',
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            if (res.Success) {
                location.reload();
            } else {
                alert(res.msg);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
});




$('.copy').click(function(e) {

$(this).prepend('<span class="copied_text">copied</span>');

setTimeout(()=>{
    $('.copied_text').remove();
},2000);

var group_id=$(this).attr('data-id');
var url=window.location.host+'/share-group/'+group_id;

var temp= $("<input>");
$('body').append(temp);
temp.val(url).select();

document.execCommand("copy");


temp.remove();

});


//join
$('.join-now').click(function(e) {
    e.preventDefault(); // Prevent default action, if any, such as form submission

    var self = $(this); // Store reference to the clicked element

    self.text('wait..');
    self.attr('disabled', 'disabled');

    var group_id = self.attr('data-id');

    $.ajax({
        url: "/join-group",
        type: 'POST',
        data: {
            group_id: group_id,
            _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token for security
        },
        success: function(res) {
            alert(res.msg);

            if (res.success) {
                location.reload();
            } else {
                self.text('Join');
                self.removeAttr('disabled');
            }
        },
        error: function(xhr, status, error) {
            alert('An error occurred: ' + error);
            self.text('Join');
            self.removeAttr('disabled');
        }
    });
});

//groupchat

$('.group-list').click(function() {
   var groupId = $(this).attr('data-id');
   global_group_id=groupId;

    $('#group-chat-container').html("");


    $('.group-start-chat').hide();
    $('.group-chat-section').show();
    loadGroupChats();


});
//groupchatscript

$('#group-chat-form').submit(function(e){
    e.preventDefault();

    var message= $('#group-message').val();

    $.ajax({
        url: '/save-group-chat',
        type: 'POST',

        data:{sender_id: sender_id, group_id:global_group_id, message:message},

        success:function(res){
            if (res.Success){
                $('#group-message').val('');

                let chat=res.data.message;
                let html=`
                <div class="current-user-chat" id='`+res.data.id+`-chat'>
                    <h5>
                `+chat+`
                    </div>

                `;
                $('#group-chat-container').append(html);

                scrollGroupChat();


            }
            else{
                alert(res.msg)
            }
        }
    });
});


});

Echo.private('broadcast-group-message').listen('.getGroupChatMessage', (data) => {

    if (sender_id != data.chat.sender_id && global_group_id == data.chat.group_id) {
        let html = `
            <div class="distance-user-chat" id='`+data.chat.id+`-chat'>
                <h5>

                <span> `+data.chat.message+`</span>
                </h5>
            </div>
        `;
        $('#group-chat-container').append(html);
        scrollGroupChat();
    }
    console.log(data);
});

function loadGroupChats() {
    $('#group-chat-container').html('');
    $.ajax({
        url: "/load-group-chats",
        type: 'POST',
        data: { group_id: global_group_id },
        success: function(res) {
            if (res.Success) {
                let chats = res.chats;
                let html = '';
                for (let i = 0; i < chats.length; i++) {
                    let addClass = "distance-user-chat";
                    if (chats[i].sender_id == sender_id) {
                        addClass = "current-user-chat";
                    }

                    let userImage = (chats[i].user_data.image == null) ? '/images/dummy.png' : chats[i].user_data.image;

                    html += `
                        <div class="${addClass}" id="${chats[i].id}-chat">
                            <h5>
                                <span>${chats[i].message}</span>
                            </h5>
                            <div class="user-data">
                                <img src="${userImage}" class="user-chat-image"/>
                                ${chats[i].sender_id == sender_id ? '<b>Me</b>' : '<b>' + chats[i].user_data.name + '</b>'}
                            </div>
                        </div>
                    `;
                }
                $('#group-chat-container').append(html);
                scrollGroupChat();
            } else {
                alert(res.msg);
            }
        }
    });
}
