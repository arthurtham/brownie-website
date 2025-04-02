<script>
    function startSubmit() {
        let submitButton = document.getElementById("submitButton")
        submitButton.disabled = true;
        submitButton.innerText = "Saving...";
        $.ajax({
            url: "/includes/admin-check-simple.php?nouicheck",
            type: "GET",
            dataType: "json",
            success: function(data) {
                if (data.status == "200") {
                    let form = document.getElementById("post-editor");
                    const requiredFields = form.querySelectorAll('[required]');
                    let isValid = true;
                    let emptyFields = [];
                    requiredFields.forEach(field => {
                        if (!field.value) {
                            emptyFields.push(field.name);
                            isValid = false;
                        }
                    });
                    if (isValid) {
                        form.submit();
                    } else {
                        alert('Error: Please fill out all required fields (Errors: ' + emptyFields.join(", ") + ')');
                        submitButton.disabled = false;
                        submitButton.innerText = "Try Saving Again";
                    }
                } else {
                    alert("Error: " + data.message);
                    submitButton.disabled = false;
                    submitButton.innerText = "Try Saving Again";
                }
            },
            error: function(xhr, status, error) {
                submitButton.disabled = false;
                submitButton.innerText = "Try Saving Again";
                alert("Error: " + error);
            }
        });
    }
</script>