$(document).ready(function () {
  $("#registrationForm").on("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = $(this).serialize(); // Collect form data

    $.ajax({
      url: "process.php", // PHP script to handle form data
      type: "POST",
      data: formData,
      dataType: "json", // Expect JSON response
      success: function (response) {
        if (response.success) {
          // Show registration details on success
          $("#resultDisplay").removeClass("hidden");
          $("#formResult").html(`
            <p><strong>Full Name:</strong> ${response.data.fullName}</p>
            <p><strong>Email:</strong> ${response.data.email}</p>
            <p><strong>Phone:</strong> ${response.data.phone}</p>
            <p><strong>Date of Birth:</strong> ${response.data.dob}</p>
            <p><strong>Gender:</strong> ${response.data.gender}</p>
            <p><strong>Address:</strong> ${response.data.address}</p>
          `);
        } else {
          alert("Error: " + response.message);
        }
      },
      error: function () {
        alert("An error occurred while submitting the form.");
      },
    });
  });
});
