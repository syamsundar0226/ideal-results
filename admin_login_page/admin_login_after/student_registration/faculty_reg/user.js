
$(document).ready(function() {
  var myDiv = $("#myDiv");
  var myDiv1 = $("#myDiv1");
  var myDiv2 = $("#myDiv2");
  var myDiv3 = $("#myDiv3");

  // slide down myDiv1 when Viewuser link is clicked
  $('#Viewuser').click(function() {
    myDiv1.slideDown();
    myDiv.slideUp();
    myDiv2.slideUp();
    myDiv3.slideUp();
  });
  
  // slide down myDiv when Adduser link is clicked
  $('#Adduser').click(function() {
    myDiv.slideDown();
    myDiv1.slideUp();
    myDiv2.slideUp();
    myDiv3.slideUp();
  });

  // slide down myDiv2 when edituser link is clicked
  $('#edituser').click(function() {
    myDiv2.slideDown();
    myDiv.slideUp();
    myDiv1.slideUp();
    myDiv3.slideUp();
  });

  $('#deluser').click(function() {
    myDiv3.slideDown();
    myDiv.slideUp();
    myDiv1.slideUp();
    myDiv2.slideUp();
  });

  // slide up all divs when any other link is clicked
  $('nav ul li a:not(#Adduser, #Viewuser, #edituser, #deluser)').click(function() {
    myDiv.slideUp();
    myDiv1.slideUp();
    myDiv2.slideUp();
    myDiv3.slideUp();
  });
});



function displayUsers() {
  var url = "viewuser.php";

  $.getJSON(url, function(data) {
    console.log(data); // add this line to log the data to the console
    var table = $("#user-list");
    table.empty();

    $.each(data, function(i, user) {
      var row = $("<tr></tr>");
      row.append($("<td>" + user.sno + "</td>"));
      row.append($("<td>" + user.name + "</td>"));
      row.append($("<td>" + user.branch + "</td>"));
      row.append($("<td>" + user.username + "</td>"));
      row.append($("<td>" + user.password + "</td>"));
      table.append(row);
    });
  });
}




const form = document.getElementById('edit-form');
form.addEventListener('submit', (event) => {
  event.preventDefault();
  
  const usernameInputs = form.querySelectorAll('input[name="name[]"]');
   const userbranchInputs = form.querySelectorAll('input[name="branch[]"]');
  const userusernameInputs = form.querySelectorAll('input[name="username[]"]');
  const passwordInputs = form.querySelectorAll('input[name="password[]"]');
  
  let hasError = false;
  
  for (let i = 0; i < usernameInputs.length; i++) {
    const usernameInput = usernameInputs[i];
    const userbranchInput = userbranchInputs[i];
    const userusernameInput = userusernameInputs[i];
    const passwordInput = passwordInputs[i];
    
    if (usernameInput.value.trim() === '') {
      hasError = true;
      usernameInput.classList.add('error');
      usernameInput.nextElementSibling.innerHTML = 'Please enter a name.';
    } else {
      usernameInput.classList.remove('error');
      usernameInput.nextElementSibling.innerHTML = '';
    }

    if (branchInput.value.trim() === '') {
      hasError = true;
      branchInput.classList.add('error');
      branchInput.nextElementSibling.innerHTML = 'Please enter a branch name.';
    } else {
      branchInput.classList.remove('error');
      branchInput.nextElementSibling.innerHTML = '';
    }
    
    if (usernameInput.value.trim() === '') {
      hasError = true;
      usernameInput.classList.add('error');
      usernameInput.nextElementSibling.innerHTML = 'Please enter an username.';
    } else {
      usernameInput.classList.remove('error');
      usernameInput.nextElementSibling.innerHTML = '';
    }
    
    if (passwordInput.value.trim() === '') {
      passwordInput.classList.remove('error');
      passwordInput.nextElementSibling.innerHTML = '';
    } else if (passwordInput.value.length <= 4) {
      hasError = true;
      passwordInput.classList.add('error');
      passwordInput.nextElementSibling.innerHTML = 'Password must be at least 4 characters long.';
    } else {
      passwordInput.classList.remove('error');
      passwordInput.nextElementSibling.innerHTML = '';
    }
  }
  
  if (!hasError) {
    const formData = new FormData(form);
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
          alert('Changes saved successfully.');
        } else {
          alert('There was an error while saving changes.');
        }
      }
    };
    xhr.open('POST', form.action, true);
    xhr.send(formData);
  }
});

form.addEventListener('input', (event) => {
  if (event.target.name === 'password[]') {
    const passwordInput = event.target;
    const confirmInput = passwordInput.nextElementSibling;
    if (passwordInput.value !== confirmInput.value) {
      confirmInput.classList.add('error');
      confirmInput.nextElementSibling.innerHTML = 'Passwords do not match.';
    } else {
      confirmInput.classList.remove('error');
      confirmInput.nextElementSibling.innerHTML = '';
    }
  }
});



function deleteUser(sno) {
  if (confirm("Are you sure you want to delete this user?")) {
    // Make an AJAX request to the server to delete the user
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // Refresh the page to update the user list
        location.reload();
      }
    };
    xhttp.open("POST", "deluser.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("sno=" + sno);
  }
}


