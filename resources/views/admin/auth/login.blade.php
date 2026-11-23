<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Admin Login | Mukoh Tires</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background: radial-gradient(circle at center, #161619 0%, #070708 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-family: 'Inter', system-ui, sans-serif;
      padding: 20px;
    }
    .login-box {
      width: 100%;
      max-width: 440px;
      background: #0f0f13;
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 12px;
      padding: 40px 36px;
      box-shadow: 0 30px 60px rgba(0, 0, 0, 0.8), 0 0 40px rgba(239, 59, 45, 0.15);
    }
    .brand-mark {
      width: 46px;
      height: 46px;
      border-radius: 50%;
      display: inline-grid;
      place-items: center;
      border: 1px solid rgba(255,255,255,.3);
      font-weight: 900;
      font-size: 22px;
      background: rgba(239,59,45,.15);
      color: #ef3b2d;
      margin: 0 auto 16px;
    }
    .form-control {
      background: #18181e !important;
      border: 1px solid rgba(255, 255, 255, 0.14) !important;
      color: #fff !important;
      padding: 12px 14px;
      font-size: 14px;
      border-radius: 8px;
    }
    .form-control:focus {
      border-color: #ef3b2d !important;
      box-shadow: 0 0 0 3px rgba(239, 59, 45, 0.25) !important;
    }
    .btn-login {
      background: #ef3b2d;
      border: none;
      color: #fff;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      padding: 13px;
      border-radius: 8px;
      width: 100%;
      font-size: 13px;
      transition: all 0.25s;
    }
    .btn-login:hover {
      background: #d82c1f;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(239, 59, 45, 0.35);
    }
    .demo-creds {
      background: rgba(255, 255, 255, 0.04);
      border: 1px dashed rgba(255, 255, 255, 0.16);
      border-radius: 8px;
      padding: 14px;
      font-size: 12px;
      color: #a1a1aa;
      margin-top: 24px;
    }
    .demo-creds strong { color: #fff; }
  </style>
</head>
<body>

  <div class="login-box">
    <div class="text-center mb-4">
      <div class="brand-mark">M</div>
      <h2 class="fs-4 fw-bold mb-1">MUKOH TIRES</h2>
      <p class="text-secondary small">Administrative Access Portal</p>
    </div>

    @if($errors->any())
      <div class="alert alert-danger bg-danger bg-opacity-10 border-danger text-danger p-2 small mb-4">
        {{ $errors->first() }}
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger bg-danger bg-opacity-10 border-danger text-danger p-2 small mb-4">
        {{ session('error') }}
      </div>
    @endif

    @if(session('success'))
      <div class="alert alert-success bg-success bg-opacity-10 border-success text-success p-2 small mb-4">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label for="email" class="form-label text-secondary small fw-bold">EMAIL ADDRESS</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', 'admin@mukohtires.com') }}" required autofocus/>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label text-secondary small fw-bold">PASSWORD</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required/>
      </div>

      <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="form-check">
          <input class="form-check-input bg-dark border-secondary" type="checkbox" id="remember" name="remember" checked>
          <label class="form-check-label text-secondary small" for="remember">Remember me</label>
        </div>
        <a href="{{ route('home') }}" class="text-secondary small">Return to Site ↗</a>
      </div>

      <button type="submit" class="btn-login">SIGN IN TO DASHBOARD</button>
    </form>

    <div class="demo-creds text-center">
      <div class="fw-bold text-white mb-1"><i class="fa-solid fa-key me-1"></i> Default Admin Credentials</div>
      Email: <strong>admin@mukohtires.com</strong><br/>
      Password: <strong>admin123</strong>
    </div>
  </div>

</body>
</html>
