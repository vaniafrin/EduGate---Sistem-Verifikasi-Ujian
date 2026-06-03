<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengawas | EduGate</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC; /* Soft grayish-blue background */
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        /* Login Card */
        .login-card {
            background: #FFFFFF;
            width: 100%;
            max-width: 420px;
            border-radius: 16px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            padding: 2.5rem 2rem;
            margin: 1rem;
        }

        /* Brand Styling */
        .brand-icon-wrapper {
            width: 56px;
            height: 56px;
            background-color: #EFF6FF;
            color: #2563EB;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem auto;
            font-size: 1.75rem;
        }
        
        .brand-title {
            color: #0F172A;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* Form Inputs */
        .form-label-custom {
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
            display: block;
        }
        .custom-input {
            border-radius: 8px;
            border: 1px solid #CBD5E1;
            padding: 0.65rem 1rem;
            font-size: 0.95rem;
            color: #0F172A;
            transition: all 0.2s;
            background-color: #FFFFFF;
        }
        .custom-input:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        /* Button */
        .btn-login {
            background-color: #2563EB;
            border-color: #2563EB;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.7rem;
            transition: all 0.2s;
        }
        .btn-login:hover {
            background-color: #1D4ED8;
            border-color: #1D4ED8;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }

        /* Alert */
        .alert-custom {
            background-color: #FEF2F2;
            border: 1px solid #FECACA;
            color: #DC2626;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <div class="brand-icon-wrapper">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <h3 class="brand-title mb-1">EduGate</h3>
        <p class="text-muted small mb-0">Portal Manajemen Ujian & Akses Pengawas</p>
    </div>

    @if($errors->any())
        <div class="alert alert-custom py-2 px-3 mb-4" role="alert">
            <i class="bi bi-exclamation-circle-fill mt-1"></i>
            <div>
                {{ $errors->first() }}
            </div>
        </div>
    @endif

    <form action="{{ route('login.proses') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="form-label-custom">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted" style="border-color: #CBD5E1; border-radius: 8px 0 0 8px;">
                    <i class="bi bi-envelope"></i>
                </span>
                <input type="email" name="email" class="form-control custom-input border-start-0 ps-0" value="{{ old('email') }}" placeholder="admin@edugate.com" required autofocus autocomplete="email">
            </div>
        </div>
        
        <div class="mb-4 pt-1">
            <label class="form-label-custom">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted" style="border-color: #CBD5E1; border-radius: 8px 0 0 8px;">
                    <i class="bi bi-key"></i>
                </span>
                <input type="password" name="password" class="form-control custom-input border-start-0 ps-0" placeholder="••••••••" required autocomplete="current-password">
            </div>
        </div>
        
        <button type="submit" class="btn btn-login btn-primary w-100 mt-2 text-white">
            Masuk
        </button>
    </form>
</div>

</body>
</html>