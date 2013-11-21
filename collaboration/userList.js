// Prompt the user for a name to use.
var name = prompt("Please enter your name", "Guest"),
           room = "hello"; //TODO: assign to the correct room name/URL

// Get a reference to the presence data in Firebase.
var userListRef = new Firebase("https://whiteboard-user.firebaseIO.com/");

// Generate a reference to a new location for my user with push.
var myUserRef = userListRef.push();

// Get a reference to my own presence status.
var connectedRef = new Firebase("https://whiteboard-user.firebaseIO.com/.info/connected");
connectedRef.on("value", function(isOnline) {
  if (isOnline.val()) {
    // If we lose our internet connection, we want ourselves removed from the list.
    myUserRef.onDisconnect().remove();
    myUserRef.set({ name: name, room: room });
  }
});

function getMessageId(snapshot) {
  return snapshot.name().replace(/[^a-z0-9\-\_]/gi,'');
}

function getCurrentRoomURL() {
  //TODO: when unique url is integrated, need to return the right url.
  return "hello";
}

// Update our GUI to show someone"s online status.
userListRef.on("child_added", function(snapshot) {
  var user = snapshot.val();
  if(user.room ==  getCurrentRoomURL()) { 
    $("<div/>")
      .attr("id", getMessageId(snapshot))
      .text(user.name)
      .appendTo("#presenceDiv");
  }
});

// Update our GUI to remove the status of a user who has left.
userListRef.on("child_removed", function(snapshot) {
  $("#presenceDiv").children("#" + getMessageId(snapshot))
    .remove();
});
