<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | {{ $profil->nama_perusahaan ?? 'Wisesa Photography' }}</title>
  <link rel="icon" href="{{ $profil && $profil->logo_perusahaan ? asset('upload/profil/' . $profil->logo_perusahaan) : asset('admin') . '/assets/images/favicon.svg' }}" type="image/x-icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
  <link rel="stylesheet" href="{{ asset('admin') }}/assets/fonts/tabler-icons.min.css">
  <link rel="stylesheet" href="{{ asset('admin') }}/assets/fonts/feather.css">
  <link rel="stylesheet" href="{{ asset('admin') }}/assets/fonts/fontawesome.css">
  <link rel="stylesheet" href="{{ asset('admin') }}/assets/fonts/material.css">
  <link rel="stylesheet" href="{{ asset('admin') }}/assets/css/style.css" id="main-style-link">
  <link rel="stylesheet" href="{{ asset('admin') }}/assets/css/style-preset.css">
  <style>
    .error-message { color: #dc3545; font-size: 0.875rem; margin-top: 5px; display: block; }
    .is-invalid { border-color: #dc3545 !important; }
    body { background: linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%); }
    .auth-header { display: flex; align-items: center; justify-content: center; gap: 10px; }
    .auth-header img { height: 42px; }
    .brand-title { font-weight: 700; letter-spacing: 0.2px; }
    .card.rounded-4 { border-radius: 1rem !important; }
    .btn[data-password-toggle] { border-left: 0; }
  </style>
  @include('sweetalert::alert')
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons/5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>

  <div class="auth-main">
    <div class="auth-wrapper v3">
      <div class="auth-form">
        <div class="auth-header">
          <a href="#" class="d-inline-flex align-items-center text-decoration-none">
            <img src="{{ $profil && $profil->logo_perusahaan ? asset('upload/profil/' . $profil->logo_perusahaan) : asset('env') . '/logo_text.png' }}" alt="{{ $profil->nama_perusahaan ?? 'Wisesa Photography' }}">
            <span class="ms-2 h5 mb-0 brand-title text-dark">{{ $profil->nama_perusahaan ?? 'Wisesa Photography' }}</span>
          </a>
        </div>
        <div class="card my-5 shadow-lg border-0 rounded-4">
          <div class="card-body p-4 p-md-5">
            <div class="mb-4">
              <h3 class="mb-0 text-center"><b>Masuk</b></h3>
            </div>
            <div class="text-center mb-4">
              <a href="{{ route('register') }}" class="link-primary">Belum punya akun?</a>
            </div>

            @if ($errors->any())
              <div class="alert alert-danger" role="alert">
                <ul class="mb-0 ps-3">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <div class="d-grid gap-2 mb-3">
              <a href="{{ route('google.login') }}" class="btn btn-light-primary bg-light text-muted">
                <img src="{{ asset('admin') }}/assets/images/authentication/google.svg" alt="img"> <span class="d-none d-sm-inline-block"> Masuk dengan Google</span>
              </a>
            </div>

            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="mb-3">
                <label for="username" class="form-label">Username atau Email</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan username atau email" required>
                @error('username')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                  <input type="password" id="password" name="password" class="form-control border-end-0 @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                  <button type="button" class="btn btn-outline-secondary border-start-0" data-password-toggle aria-label="Tampilkan password" aria-pressed="false">
                    <ion-icon name="eye-outline"></ion-icon>
                  </button>
                  @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                  <input class="form-check-input input-primary" type="checkbox" id="remember-me" name="remember-me">
                  <label class="form-check-label" for="remember-me">Ingat saya</label>
                </div>
                <a href="{{ route('forgot-password') }}" class="text-secondary">Lupa password?</a>
              </div>
              <div class="d-grid mt-2">
                <button type="submit" class="btn btn-primary">Masuk</button>
              </div>
            </form>
          </div>
        </div>
        <div class="auth-footer row align-items-center">
          <div class="col my-1">
            <p class="m-0">&copy; {{ date('Y') }} <span class="fw-semibold">{{ $profil->nama_perusahaan ?? 'Wisesa Photography' }}</span></p>
          </div>
          <div class="col-auto my-1">
            <ul class="list-inline footer-link mb-0">
              <li class="list-inline-item"><a href="{{ url('/') }}">Home</a></li>
              <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
              <li class="list-inline-item"><a href="#">Contact</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('sweetalert::alert')

  <script src="{{ asset('admin') }}/assets/js/plugins/popper.min.js"></script>
  <script src="{{ asset('admin') }}/assets/js/plugins/simplebar.min.js"></script>
  <script src="{{ asset('admin') }}/assets/js/plugins/bootstrap.min.js"></script>
  <script src="{{ asset('admin') }}/assets/js/fonts/custom-font.js"></script>
  <script src="{{ asset('admin') }}/assets/js/pcoded.js"></script>
  <script src="{{ asset('admin') }}/assets/js/plugins/feather.min.js"></script>
  <script>layout_change('light');</script>
  <script>change_box_container('false');</script>
  <script>layout_rtl_change('false');</script>
  <script>preset_change("preset-1");</script>
  <script>font_change("Public-Sans");</script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggleBtn = document.querySelector('[data-password-toggle]');
      const passwordInput = document.getElementById('password');
      if (!toggleBtn || !passwordInput) return;

      toggleBtn.addEventListener('click', function () {
        const isHidden = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isHidden ? 'text' : 'password');

        const icon = toggleBtn.querySelector('ion-icon');
        if (icon) {
          icon.setAttribute('name', isHidden ? 'eye-off-outline' : 'eye-outline');
        }

        toggleBtn.setAttribute('aria-pressed', String(isHidden));
        toggleBtn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
      });
    });
  </script>
</body>

</html>