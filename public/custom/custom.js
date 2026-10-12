// gateway

$(document).ready(function () {
    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#CreateGetwaySubmitBtn").click(function () {
        $.ajax({
            type: "POST",
            url: "/gateways",
            data: $("#createGatewayForm").serialize(),
            success: function (response) {
                // Clear form fields
                $("#createGatewayForm")[0].reset();

                // Show Snackbar notification
                Snackbar.show({
                    text: "Gateway created successfully.",
                    duration: 5000, // 5 seconds
                });
            },
            error: function (xhr, status, error) {
                var err = JSON.parse(xhr.responseText);
                console.log("Error:", err);

                // Display validation errors
                $.each(err.errors, function (key, value) {
                    $("#" + key + "_error").text(value);
                });
            },
        });
    });
});

//brands

$(document).ready(function () {
    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#CreateBrandSubmitBtn").click(function () {
        var formData = new FormData($("#createBrandForm")[0]); // Convert form to FormData

        $.ajax({
            type: "POST",
            url: "/brands",
            data: formData, // Use FormData instead of serialize()
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting contentType
            success: function (response) {
                // Clear form fields
                $("#createBrandForm")[0].reset();

                // Show Snackbar notification
                Snackbar.show({
                    text: "Brand created successfully.",
                    duration: 5000, // 5 seconds
                });
            },
            error: function (xhr, status, error) {
                var err = JSON.parse(xhr.responseText);
                console.log("Error:", err);

                // Display validation errors
                $.each(err.errors, function (key, value) {
                    $("#" + key + "_error").text(value);
                });
            },
        });
    });
});

//customers

$(document).ready(function () {
    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#CreateCustomerSubmitBtn").click(function () {
        $.ajax({
            type: "POST",
            url: "/customers",
            data: $("#createCustomerForm").serialize(),
            success: function (response) {
                // Clear form fields
                $("#createCustomerForm")[0].reset();

                // Show Snackbar notification
                Snackbar.show({
                    text: "Customer created successfully.",
                    duration: 5000, // 5 seconds
                });
            },
            error: function (xhr, status, error) {
                var err = JSON.parse(xhr.responseText);
                console.log("Error:", err);

                // Display validation errors
                $.each(err.errors, function (key, value) {
                    $("#" + key + "_error").text(value);
                });
            },
        });
    });
});

//users

$(document).ready(function () {
    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#CreateUserSubmitBtn").click(function () {
        $.ajax({
            type: "POST",
            url: "/users",
            data: $("#createUserForm").serialize(),
            success: function (response) {
                // Clear form fields
                $("#createUserForm")[0].reset();

                // Show Snackbar notification
                Snackbar.show({
                    text: "User created successfully.",
                    duration: 5000, // 5 seconds
                });
            },
            error: function (xhr, status, error) {
                var err = JSON.parse(xhr.responseText);
                console.log("Error:", err);

                // Display validation errors
                $.each(err.errors, function (key, value) {
                    $("#" + key + "_error").text(value);
                });
            },
        });
    });
});

$(document).ready(function () {
    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#createPrimaryEmailSubmitBtn").click(function () {
        $.ajax({
            type: "POST",
            url: "/set-primary-email",
            data: $("#createPrimaryEmailForm").serialize(),
            success: function (response) {
                // Clear form fields
                $("#createPrimaryEmailForm")[0].reset();

                // Show Snackbar notification
                Snackbar.show({
                    text: "Primary Email Updated created successfully.",
                    duration: 5000, // 5 seconds
                });
            },
            error: function (xhr, status, error) {
                var err = JSON.parse(xhr.responseText);
                Snackbar.show({
                    text: err,
                    duration: 5000, // 5 seconds
                });
                console.log("Error:", err);

                // Display validation errors
                $.each(err.errors, function (key, value) {
                    $("#" + key + "_error").text(value);
                });
            },
        });
    });
});



