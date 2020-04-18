//sign in button
function onSignIn(googleUser) {
    // getting user details
    var profile = googleUser.getBasicProfile();
    // setting values
    document.getElementById("name").innerText = profile.getName();
    document.getElementById("email").innerText = profile.getEmail();
    document.getElementById("user-image").src = profile.getImageUrl();
    //showing the fields
    document.getElementById("user-content").style.display = "block";
}

//log out button
function logOut() {
    var user = gapi.auth2.getAuthInstance();
    user.signOut();
    //hiding the fields of name, email and image
    document.getElementById("user-content").style.display = "none";
}
