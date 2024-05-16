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
                    <!-- Form -->
                    <form enctype="multipart/form-data" method="POST" id="register_user">
                        <!-- First Name -->
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" placeholder="Enter your first name">
                        </div>
                        <!-- Last Name -->
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Enter your last name">
                        </div>
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email">
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter your password">
                        </div>
                        <!-- Type of users -->
                        <div class="mb-3">
                            <label for="userType" class="form-label">Type of User</label>
                            <select class="form-select" name="user_type">
                                <option value="Dealer" selected>Dealer</option>
                                <option value="Employee">Employee</option>
                            </select>
                        </div>
                        <div id="dealer_details">
                            <!-- City -->
                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city" required>
                            </div>
                            <!-- State -->
                            <div class="mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state" placeholder="Enter your state" required>
                            </div>
                            <!-- Zip code -->
                            <div class="mb-3">
                                <label for="zip_code" class="form-label">Zip code</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Enter your zip code" required>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Register</button>
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