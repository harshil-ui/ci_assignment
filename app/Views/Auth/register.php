<?= $this->extend('Auth/layout') ?>

<?= $this->section('title') ?>
Register
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <!-- Card -->
            <div class="card my-5">
                <h5 class="card-header">Registration Form</h5>
                <div class="card-body">

                    <form enctype="multipart/form-data" method="POST" id="register_user">

                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" placeholder="Enter your first name">
                        </div>

                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Enter your last name">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter your password">
                        </div>

                        <div class="mb-3">
                            <label for="userType" class="form-label">Type of User</label>
                            <select class="form-select" name="user_type">
                                <option value="Dealer" selected>Dealer</option>
                                <option value="Employee">Employee</option>
                            </select>
                        </div>

                        <div id="dealer_details">

                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city">
                            </div>

                            <div class="mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state" placeholder="Enter your state">
                            </div>

                            <div class="mb-3">
                                <label for="zip_code" class="form-label">Zip code</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Enter your zip code">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Register</button>

                        <a href="<?= site_url('login') ?>">Already have an account</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(document).ready(function() {

        $('[name="user_type"]').change(function() {
            let userType = $(this).val();
            if (userType === 'Dealer') {
                $('#dealer_details').show();
                $('#city').attr('required', 'required');
                $('#state').attr('required', 'required');
                $('#zip_code').attr('required', 'required');
            } else {
                $('#dealer_details').hide();
                $('#city').removeAttr('required');
                $('#state').removeAttr('required');
                $('#zip_code').removeAttr('required');
            }
        });

        $('#register_user').on('submit', function(event) {
            event.preventDefault();

            let firstName = $('[name="first_name"]').val();
            let lastName = $('[name="last_name"]').val();
            let email = $('[name="email"]').val();
            let password = $('[name="password"]').val();
            let userType = $('[name="user_type"]').val();
            let city = $('[name="city"]').val();
            let state = $('[name="state"]').val();
            let zipCode = $('[name="zip_code"]').val();

            if (firstName == '') {
                alert("First name field is required!");
                return false;
            }

            if (lastName == '') {
                alert("Last name field is required!");
                return false;
            }

            if (email == '') {
                let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!regex.test(email)) {
                    alert("Please enter a valid email address");
                    return false;
                }
            }

            if (password != '') {
                if (password.length < 8) {
                    alert("Password must be minimum 8 length");
                    return false;
                }

            }

            if (password == '') {
                alert('Password field is required');
                return false;
            }

            if (userType == 'Dealer') {
                if (city == '') {
                    alert("Please enter city");
                    return false;
                }

                if (state == '') {
                    alert('Please enter state');
                    return false;
                }

                if (zipCode == '') {
                    alert('Please enter Zip code');
                    return false;
                }
            }

            $.ajax({
                type: 'POST',
                url: '<?= site_url('post-register'); ?>',
                data: $(this).serialize(),
                dataType: 'JSON',
                complete(xhr) {
                    let jsonResponse = JSON.parse(xhr.responseText);
                    if (jsonResponse.success) {
                        alert(jsonResponse.message);
                        window.location.href = '/';
                    } else {
                        alert(JSON.stringify(jsonResponse.errors));
                    }
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>