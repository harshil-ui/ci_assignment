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
        $('#register_user').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                type: 'POST',
                url: '<?= site_url('post-register'); ?>',
                data: $(this).serialize(),
                dataType: 'JSON',
                success: function(data) {
                    if (data.success) {
                        alert(data.message);
                        window.location.href = '/';
                    } else {
                        alert(data.errors);
                    }
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>