<?= $this->extend('Auth/layout') ?>

<?= $this->section('title') ?>
Login
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <!-- Card for Login Form -->
            <div class="card my-5">
                <div class="card-header">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    <!-- Form Start -->
                    <form method="POST" id="user_login">
                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                        </div>
                        <!-- Password Input -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <!-- Login Button -->
                        <button type="submit" class="btn btn-primary">Login</button>
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
        $('#user_login').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                type: 'POST',
                url: '<?= site_url('post-login'); ?>',
                data: $(this).serialize(),
                dataType: 'JSON',
                success: function(data) {
                    if (data.success) {
                        alert(data.message);
                        window.location.href = '/';
                    } else {
                        alert(data.message);
                    }
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>