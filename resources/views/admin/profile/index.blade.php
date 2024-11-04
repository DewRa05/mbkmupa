@extends('admin.layouts.app')

@section('title', 'Edit Profile')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Profile</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5><i class="fas fa-user-edit"></i> Update Your Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <form id="adminProfileForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Profile Picture Preview -->
                            <div class="text-center mb-4">
                                <img id="profilePreview" src="{{ asset('img/user/admin/' . $admin->profile) }}" alt="Profile Picture" class="rounded-circle border border-primary shadow-sm" width="150" height="150">
                            </div>

                            <!-- Profile Picture -->
                            <div class="mb-3 text-center">
                                <label for="profile" class="form-label">Upload Profile Picture</label>
                                <input type="file" class="form-control" name="profile" id="profile" accept="image/*" data-bs-toggle="tooltip" data-bs-placement="top" title="Choose a profile picture (Max 2MB)">
                            </div>

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="nama" id="nama" value="{{ $admin->nama }}" required data-bs-toggle="tooltip" data-bs-placement="top" title="Enter your full name">
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ $admin->email }}" required data-bs-toggle="tooltip" data-bs-placement="top" title="Enter a valid email address">
                            </div>

                            <!-- Password (Optional) with Toggle -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password (Leave blank to keep current)</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="New Password" data-bs-toggle="tooltip" data-bs-placement="top" title="Leave blank to keep current password">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <div id="successMessage" class="alert alert-success alert-dismissible fade show mt-4 text-center" style="display: none;" role="alert">
            <strong>Success!</strong> Profile updated successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    // Preview Profile Picture Before Upload
    document.getElementById('profile').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            document.getElementById('profilePreview').src = URL.createObjectURL(file);
        }
    });

    // Password show/hide toggle functionality
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        toggleIcon.classList.toggle('fa-eye');
        toggleIcon.classList.toggle('fa-eye-slash');
    });

    // Ajax form submission
    $('#adminProfileForm').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Prepare form data
        var formData = new FormData(this);
        if (!$('#password').val()) {
            formData.delete('password'); // Remove password if not provided
        }

        // Make an AJAX request
        $.ajax({
            url: '{{ route("admin.profile.update", $admin->id) }}', // Update URL
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 'success') {
                    $('#successMessage').show(); // Show success message
                    setTimeout(function() {
                        $('#successMessage').fadeOut();
                    }, 3000); // Hide after 3 seconds
                }
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endsection
