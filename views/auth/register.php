<html>
<head>
    <title>Sign up</title>
    <?php require 'views/partials/headers.php' ?>
</head>
<body>
<?php
require 'views/partials/nav_bar.php'
?>
<div class="container-fluid">
    <!--    nav bar -->

    <!-- login-->
    <div class="row m-3">
        <div class="col-md-4 offset-md-4">
            <?php
            isset($data) ? Message::AlertDanger($data) : '';
            ?>
            <div class="card card-custom bg-white border-white border-0">
                <div class="card-body">
                    <form method="post" action="<?php echo Route::to('registerStore', 'AuthController', null) ?>">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Full Name" name="name"
                                   required>

                            <div class="invalid-feedback">
                                user name must be greater than 6 char and required
                            </div>
                            <div class="valid-feedback">
                                valid user name
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email"
                                   aria-describedby="emailHelp" placeholder="Enter email" name="email" required>
                            <div class="invalid-feedback">
                                invalid email
                            </div>
                            <div class="valid-feedback">
                                valid email
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password"
                                   placeholder="Password" name="password" required>

                            <div class="invalid-feedback">
                                password must be greater than 6 char and required
                            </div>
                            <div class="valid-feedback">
                                valid password
                            </div>
                        </div>

                        <button id="submit_btn" type="submit" class="btn btn-outline-primary btn-block"><i class="fas fa-user-plus"></i> Register</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <!--    -->

</div>

<?php
require 'views/partials/footer.php'
?>


<script>


    var validEmail = false;
    var validPassword = false;
    var validName = false;


    $(document).ready(function () {
        //jQuery code goes here
        checkIfAllValid();

        $('#email').on('input', function () {
            var input = $(this);
            var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            var is_email = re.test(input.val());
            if (is_email) {
                input.removeClass("is-invalid").addClass("is-valid");
                validEmail = true;
                checkIfAllValid()
            } else {
                input.removeClass("is-valid").addClass("is-invalid");
                validEmail = false;
                checkIfAllValid();
            }
        });


        $('#password').on('input', function () {
            var input = $(this);
            var is_name = input.val();
            console.log(is_name);
            if (is_name && is_name.length > 6) {
                input.removeClass("is-invalid").addClass("is-valid");
                validPassword = true;
                checkIfAllValid();
            } else {
                input.removeClass("is-valid").addClass("is-invalid");
                validPassword = false;
                checkIfAllValid();

            }
        });
        $('#name').on('input', function () {
            var input = $(this);
            var is_name = input.val();
            console.log(is_name);
            if (is_name && is_name.length > 6) {
                input.removeClass("is-invalid").addClass("is-valid");
                validName = true;
                checkIfAllValid();
            } else {
                input.removeClass("is-valid").addClass("is-invalid");
                validName = false;
                checkIfAllValid();

            }
        });


        function checkIfAllValid() {

            if (validPassword && validEmail && validName) {
                $('#submit_btn').prop('disabled', false);
            } else {
                $('#submit_btn').prop('disabled', true);

            }
        }

    });


</script>
</body>
</html>

