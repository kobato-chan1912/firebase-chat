<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.2.1/firebase-database.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyC-ckWw1E8OAeKhkcv2Zl-C1KpK6ChW3_g",
    authDomain: "my-chat-app-57447.firebaseapp.com",
    projectId: "my-chat-app-57447",
    storageBucket: "my-chat-app-57447.appspot.com",
    messagingSenderId: "741659392427",
    appId: "1:741659392427:web:72b23a20c44de38203faee"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  var myName = prompt("Enter your name");

</script>
<!-- create a form to send message -->
<form onsubmit="return sendMessage();">
    <input id="message" placeholder="Enter message" autocomplete="off">
 
    <input type="submit">
</form>
<ul id="messages"></ul>

<script>
    function sendMessage() {
        // get message
        var message = document.getElementById("message").value;
 
        // save in database
        firebase.database().ref("messages").push().set({
            "sender": myName,
            "message": message
        });
 
        // prevent form from submitting
        return false;
    }
    function deleteMessage(self){
        var messageId = self.getAttribute("data-id");
        firebase.database().ref("messages").child(messageId).remove();
    }


        //listen for incoming message.
        firebase.database().ref("messages").on("child_added", function(snapshot){
            var html = "";
            html+= "<li id='message-" + snapshot.key + "'>";
            if(snapshot.val().sender == myName){
                html += "<button data-id='" + snapshot.key + "' onclick='deleteMessage(this);'>";
                html += "Delete";
                html += "</button>";
            }
            html+= snapshot.val().sender + ": " + snapshot.val().message;
            html+= "</li>";
            document.getElementById("messages").innerHTML += html;
        });

        //listenning for remove message. 
        firebase.database().ref("messages").on("child_removed", function(snapshot){
            document.getElementById("message-" + snapshot.key).innerHTML = "This message has been removed";
        });
    
</script>