{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Escolar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        *{box-sizing:border-box;margin:0;padding:0}

        :root{
            --sidebar-bg:#1a2238;
            --blue:#2d6ef7;
            --page-bg:#f0f2f5;
            --border:#e8eaf0;
            --text:#1a2238;
            --muted:#6b7280;
        }

        body{
            font-family:Arial, Helvetica, sans-serif;
            background:var(--page-bg);
            min-height:100vh;
            display:flex;
        }

        .panel-left{
            width:420px;
            min-height:100vh;
            background:var(--sidebar-bg);
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            padding:3rem;
            color:#fff;
        }

        .brand{
            display:flex;
            align-items:center;
            gap:.75rem;
        }

        .brand-icon{
            width:44px;
            height:44px;
            background:var(--blue);
            border-radius:10px;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .brand-name{
            font-size:1.1rem;
            font-weight:700;
        }

        .panel-tagline h2{
            font-size:1.8rem;
            margin-bottom:1rem;
        }

        .panel-tagline p{
            color:#cbd5e1;
        }

        .badge-item{
            display:flex;
            align-items:center;
            gap:.75rem;
            border:1px solid rgba(255,255,255,.1);
            padding:.75rem 1rem;
            border-radius:8px;
            margin-bottom:.75rem;
        }

        .panel-right{
            flex:1;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:2rem;
        }

        .login-card{
            width:100%;
            max-width:400px;
        }

        .subtitle{
            color:var(--muted);
            margin-bottom:2rem;
        }

        .form-label{
            font-weight:600;
            margin-bottom:.4rem;
        }

        .input-group-custom{
            position:relative;
            margin-bottom:1rem;
        }

        .input-icon{
            position:absolute;
            left:14px;
            top:50%;
            transform:translateY(-50%);
        }

        .form-control{
            padding-left:2.5rem !important;
            height:48px;
        }

        .toggle-pw{
            position:absolute;
            right:12px;
            top:50%;
            transform:translateY(-50%);
            border:none;
            background:none;
        }

        .btn-login{
            width:100%;
            height:48px;
            border:none;
            border-radius:8px;
            background:var(--blue);
            color:#fff;
            font-weight:600;
        }

        .remember-row{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:1rem;
        }

        @media(max-width:768px){
            .panel-left{display:none;}
        }
    </style>
</head>
<body>

<div class="panel-left">
    <div class="brand">
        <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <div class="brand-name">Sistema Escolar</div>
    </div>

    <div class="panel-tagline">
        <h2>Acesso ao Sistema</h2>
        <p>Entre com suas credenciais para continuar.</p>
    </div>

    <div>
        <div class="badge-item"><i class="bi bi-bell-fill"></i><span>Consulta de comunicados</span></div>
        <div class="badge-item"><i class="bi bi-grid-3x3-gap-fill"></i><span>Consulta de horários</span></div>
        <div class="badge-item"><i class="bi bi-book-fill"></i><span>Serviços acadêmicos</span></div>
    </div>
</div>

<div class="panel-right">
    <div class="login-card">

        <h3>Login</h3>
        <p class="subtitle">Informe seus dados de acesso.</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <label class="form-label">E-mail</label>
            <div class="input-group-custom">
                <i class="bi bi-envelope input-icon"></i>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <label class="form-label">Senha</label>
            <div class="input-group-custom">
                <i class="bi bi-lock input-icon"></i>
                <input id="senha" type="password" name="password" class="form-control">
                <button type="button" class="toggle-pw" onclick="toggleSenha()">
                    <i class="bi bi-eye" id="icon-senha"></i>
                </button>
            </div>

            <div class="remember-row">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Lembrar de mim</label>
                </div>
            </div>

            <button type="submit" class="btn-login">Entrar</button>
        </form>
    </div>
</div>
<div class="remember-row">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
    </div>
    {{-- Link esqueci a senha --}}
    <a href="forgot-passoword.blade.php"
       style="font-size:.85rem;color:var(--blue);text-decoration:none;font-weight:600;">
        Esqueci a senha
    </a>
</div>

<script>
function toggleSenha(){
    const input=document.getElementById('senha');
    const icon=document.getElementById('icon-senha');

    if(input.type==='password'){
        input.type='text';
        icon.className='bi bi-eye-slash';
    }else{
        input.type='password';
        icon.className='bi bi-eye';
    }
}
</script>

</body>
</html>
