<div class="settings-content">
    <h2 class="content-title">Pengaturan Akun</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.settings.update') }}" method="POST" class="settings-form" enctype="multipart/form-data">
        @csrf

        <!-- Avatar Section -->
        <div class="avatar-section">
           
            <div class="current-avatar">
            @if($user->avatar)
                <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar" class="avatar-preview avatar-size">
            @else
                <img src="{{ asset('images/default-avatar.svg') }}" alt="Default Avatar" class="avatar-preview avatar-size">
            @endif
            </div>

            <div class="form-group">
            <label for="avatar" class="file-upload-label">
                <i class="fas fa-cloud-upload-alt"></i>
                Pilih Foto
            </label>
            <input type="file" name="avatar" id="avatar" 
                   class="form-control file-upload @error('avatar') is-invalid @enderror" 
                   accept="image/*">
            @error('avatar')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            </div>
        </div>

    <style>
    .avatar-size {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        margin-top: 10px;
    }
    </style>

        <!-- Personal Information -->
        <div class="form-section">
            <h3>Informasi Pribadi</h3>
            
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" 
                       value="{{ old('name', $user->name) }}" 
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Masukkan nama lengkap">
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" 
                       value="{{ old('email', $user->email) }}" 
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="Masukkan alamat email">
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Password Section -->
        <div class="form-section">
            <h3>Ubah Password</h3>
            
            <div class="form-group">
                <label for="password">Password Baru</label>
                <div class="password-input-group">
                    <input type="password" id="password" name="password" 
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Masukkan password baru">
                    <i class="fas fa-eye-slash toggle-password"></i>
                </div>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="password-input-group">
                    <input type="password" id="password_confirmation" 
                           name="password_confirmation" 
                           class="form-control"
                           placeholder="Konfirmasi password baru">
                    <i class="fas fa-eye-slash toggle-password"></i>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-dark text-white">
            <i class="fas fa-save"></i>
            Simpan Perubahan
            </button>
        </div>
        </form>
    </div>

<script>


document.addEventListener('DOMContentLoaded', function () {
    const avatarInput = document.getElementById('avatar');
    const avatarContainer = document.querySelector('.current-avatar');

    avatarInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                // Buat elemen <img> baru untuk preview
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Preview Avatar';
                img.className = 'avatar-preview avatar-size';

                // Hapus isi container lama (avatar lama atau ikon default)
                avatarContainer.innerHTML = '';
                avatarContainer.appendChild(img);
            };

            reader.readAsDataURL(this.files[0]);
        }
    });
});


// Toggle password visibility
document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', function() {
        const input = this.previousElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        } else {
            input.type = 'password';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        }
    });
});
</script>