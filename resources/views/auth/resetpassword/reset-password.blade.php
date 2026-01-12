<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | StarterKit-v2</title>
  <link rel="icon" href="{{ asset('admin') }}/assets/images/favicon.svg" type="image/x-icon">
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
  </style>
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
            <img src="{{ asset('env') }}/logo_text.png" alt="StarterKit-v2">
            <span class="ms-2 h5 mb-0 brand-title text-dark">StarterKit-v2</span>
          </a>
        </div>
        <div class="card my-5 shadow-lg border-0 rounded-4">
          <div class="card-body p-4 p-md-5">
            <div class="mb-4">
              <h3 class="mb-0 text-center"><b>Reset Password</b></h3>
            </div>
            <div class="text-center mb-4">
              <a href="{{ route('login') }}" class="link-primary">Masuk</a>
            </div>

            <form action="{{ route('forgot-password.reset-password') }}" method="POST">
              @csrf
              <input type="hidden" name="no_wa" value="{{ $no_wa }}">
              <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <div class="input-group">
                  <input type="password" id="password" name="password" class="form-control border-end-0" placeholder="Buat password baru yang kuat" required>
                  <button type="button" class="btn btn-outline-secondary border-start-0" data-password-toggle aria-label="Tampilkan password" aria-pressed="false">
                    <ion-icon name="eye-outline"></ion-icon>
                  </button>
                </div>
                <div class="form-text">Minimal 6 karakter</div>
              </div>
              <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <div class="input-group">
                  <input type="password" id="password_confirmation" name="password_confirmation" class="form-control border-end-0" placeholder="Ulangi password baru Anda" required>
                  <button type="button" class="btn btn-outline-secondary border-start-0" data-password-toggle aria-label="Tampilkan password" aria-pressed="false">
                    <ion-icon name="eye-outline"></ion-icon>
                  </button>
                </div>
              </div>
              <div class="d-grid mt-2">
                <button type="submit" class="btn btn-primary">Reset Password</button>
              </div>
            </form>
          </div>
        </div>
        <div class="auth-footer row align-items-center">
          <div class="col my-1">
            <p class="m-0">&copy; {{ date('Y') }} <span class="fw-semibold">StarterKit-v2</span></p>
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
      document.querySelectorAll('[data-password-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function () {
          const group = btn.closest('.input-group');
          if (!group) return;
          const input = group.querySelector('input[type="password"], input[type="text"]');
          if (!input) return;
          const isHidden = input.getAttribute('type') === 'password';
          input.setAttribute('type', isHidden ? 'text' : 'password');
          const icon = btn.querySelector('ion-icon');
          if (icon) {
            icon.setAttribute('name', isHidden ? 'eye-off-outline' : 'eye-outline');
          }
          btn.setAttribute('aria-pressed', String(isHidden));
          btn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
        });
      });
    });
  </script>
</body>

</html>