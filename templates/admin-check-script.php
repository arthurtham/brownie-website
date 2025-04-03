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
                    const patternFields = form.querySelectorAll('[pattern]');
                    let isValid = true;
                    let emptyFields = [];
                    let invalidFields = [];
                    requiredFields.forEach(field => {
                        if (!field.value) {
                            emptyFields.push(field.name);
                            isValid = false;
                        }
                    });
                    patternFields.forEach(field => {
                        if (!field.checkValidity()) {
                            invalidFields.push(field.name);
                            isValid = false;
                        }
                        // const regex = new RegExp(field.pattern);
                        // if (!regex.test(field.value) && !emptyFields.includes(field.name)) {
                        //     invalidFields.push(field.name);
                        //     isValid = false;
                        // }
                    });                            
                    if (isValid) {
                        form.submit();
                    } else {
                        alert('Error: Please fix the following inputs: \n\Required fields: ' + emptyFields.join(", ") + '\nInvalid pattern: ' + invalidFields.join(", "));
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