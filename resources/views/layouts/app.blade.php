<!doctype html>
<html lang="lv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Bibliotēkas sistēma')</title>

    <style>
        :root{
            --c1:#5D455F;
            --c2:#896F8C;
            --c3:#A698AE;
            --c4:#C0B6BF;
            --c5:#A9A5BA;
            --c6:#6D7988;
            --white:#f8f7fb;
            --text:#241f28;
            --shadow:0 18px 45px rgba(44,33,47,.16);
            --radius-xl:24px;
            --radius-lg:18px;
            --radius-md:14px;
            --radius-sm:10px;
            --border:1px solid rgba(93,69,95,.14);
        }

        *{box-sizing:border-box}
        html{scroll-behavior:smooth}
        body{
            margin:0;
            min-height:100vh;
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            color:var(--text);
            background:
                radial-gradient(circle at top left, rgba(169,165,186,.45), transparent 28%),
                radial-gradient(circle at top right, rgba(137,111,140,.28), transparent 32%),
                linear-gradient(180deg, #f6f3f8 0%, #ebe7ef 100%);
        }

        a{color:var(--c1);text-decoration:none}
        a:hover{color:var(--c6)}
        img{max-width:100%;display:block}

        .site-shell{
            min-height:100vh;
            display:flex;
            flex-direction:column;
        }

        .site-header{
            position:sticky;
            top:0;
            z-index:50;
            backdrop-filter:blur(16px);
            background:rgba(246,243,248,.82);
            border-bottom:1px solid rgba(93,69,95,.12);
        }

        .header-inner,
        .page-wrap,
        .footer-inner{
            width:min(1240px, calc(100% - 32px));
            margin:0 auto;
        }

        .header-inner{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:18px;
            padding:14px 0;
            flex-wrap:wrap;
        }

        .brand{
            display:flex;
            align-items:center;
            gap:14px;
            min-width:240px;
        }

        .brand-mark{
            width:52px;
            height:52px;
            border-radius:16px;
            background:linear-gradient(145deg,var(--c1),var(--c2),var(--c6));
            box-shadow:var(--shadow);
            position:relative;
            overflow:hidden;
        }

        .brand-mark::before,
        .brand-mark::after{
            content:"";
            position:absolute;
            inset:auto;
            border-radius:999px;
            background:rgba(255,255,255,.22);
        }
        .brand-mark::before{width:38px;height:38px;top:-8px;right:-10px}
        .brand-mark::after{width:24px;height:24px;left:8px;bottom:6px}

        .brand-text strong{
            display:block;
            color:var(--c1);
            font-size:1.05rem;
            letter-spacing:.04em;
        }
        .brand-text span{
            display:block;
            color:#6f6474;
            font-size:.9rem;
        }

        .nav-links{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            flex-wrap:wrap;
            flex:1 1 420px;
        }

        .nav-link{
            padding:10px 16px;
            border-radius:999px;
            color:var(--c1);
            font-weight:600;
            background:rgba(255,255,255,.52);
            border:1px solid rgba(137,111,140,.18);
            transition:.22s ease;
        }
        .nav-link:hover{
            transform:translateY(-1px);
            background:linear-gradient(135deg, rgba(137,111,140,.18), rgba(169,165,186,.18));
            color:var(--c1);
        }

        .user-panel{
            display:flex;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
            justify-content:flex-end;
        }

        .user-chip{
            padding:10px 14px;
            border-radius:999px;
            background:linear-gradient(135deg, rgba(137,111,140,.18), rgba(169,165,186,.26));
            border:1px solid rgba(93,69,95,.14);
            color:var(--c1);
            font-size:.94rem;
            font-weight:600;
        }

        .btn,
        button,
        input[type="submit"]{
            appearance:none;
            border:none;
            outline:none;
            cursor:pointer;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            padding:12px 18px;
            border-radius:12px;
            background:linear-gradient(135deg,var(--c1),var(--c2));
            color:var(--white) !important;
            font-weight:700;
            letter-spacing:.02em;
            box-shadow:0 12px 26px rgba(93,69,95,.22);
            transition:transform .2s ease, box-shadow .2s ease, opacity .2s ease;
        }
        .btn:hover,
        button:hover,
        input[type="submit"]:hover{
            transform:translateY(-2px);
            box-shadow:0 16px 34px rgba(93,69,95,.28);
            color:var(--white) !important;
        }
        .btn.secondary,
        .btn-delete,
        .btn-outline,
        .btn-secondary{
            background:transparent;
            color:var(--c1) !important;
            border:1px solid rgba(93,69,95,.2);
            box-shadow:none;
        }
        .btn.edit{background:linear-gradient(135deg,var(--c2),var(--c6))}
        .btn.delete{background:linear-gradient(135deg,#8d5f72,#6b4a5d)}
        .btn-sm{padding:9px 14px;font-size:.92rem}

        .page-wrap{
            width:min(1240px, calc(100% - 32px));
            margin:26px auto 40px auto;
            display:grid;
            grid-template-columns:minmax(0,1fr);
            gap:24px;
            flex:1;
        }

        .main-panel{
            min-width:0;
        }

        .hero-panel,
        .card,
        .client-card,
        .surface,
        .table-wrap,
        .auth-card,
        .event-details-card,
        .jumbotron{
            background:rgba(255,255,255,.72);
            border:var(--border);
            box-shadow:var(--shadow);
            border-radius:var(--radius-xl);
            backdrop-filter:blur(10px);
        }

        .hero-panel,
        .jumbotron{
            position:relative;
            overflow:hidden;
            padding:34px;
            background:
                linear-gradient(135deg, rgba(93,69,95,.95), rgba(137,111,140,.84) 48%, rgba(109,121,136,.9));
            color:#fff;
        }
        .hero-panel::after,
        .jumbotron::after{
            content:"";
            position:absolute;
            width:220px;
            height:220px;
            right:-50px;
            top:-80px;
            border-radius:50%;
            background:rgba(255,255,255,.12);
        }
        .hero-panel h1,
        .hero-panel h2,
        .jumbotron h1,
        .jumbotron h2,
        .jumbotron .display-4{
            color:#fff;
            margin:0 0 10px 0;
            font-size:clamp(2rem, 4vw, 3.2rem);
            line-height:1.05;
        }
        .hero-panel p,
        .jumbotron .lead{
            color:rgba(255,255,255,.9);
            font-size:1.05rem;
            max-width:760px;
            margin:0;
        }

        .section-title,
        h1,h2,h3,h4,h5{
            color:var(--c1);
            margin-top:0;
        }
        h1{font-size:2rem}
        h2{font-size:1.5rem}
        h3{font-size:1.2rem}

        .container,
        .container.mt-5,
        .container.mx-auto{
            width:100%;
            max-width:none;
            margin:0;
            padding:0;
        }

        .row{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:24px;
            margin-top:24px;
        }
        .col-md-6{min-width:0}
        .mb-3{margin-bottom:18px}
        .mb-4{margin-bottom:18px}
        .mb-6{margin-bottom:24px}
        .mt-5{margin-top:0!important}
        .p-5{padding:0!important}
        .rounded{border-radius:var(--radius-xl)!important}
        .bg-light,.bg-white{background:transparent!important}
        .shadow-md,.shadow{box-shadow:none!important}

        .card{
            padding:20px;
            color:var(--text);
        }
        .card-body{padding:0}
        .card-title{margin-bottom:8px}
        .card-text{color:#504756; line-height:1.6}
        .card-img-top{
            width:100%;
            border-radius:16px;
            margin-bottom:16px;
        }

        .client-container{
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));
            gap:20px;
            margin-top:18px;
            padding:0;
            background:none;
            box-shadow:none;
        }
        .client-card{
            padding:20px;
            transition:transform .2s ease, box-shadow .2s ease;
        }
        .client-card:hover,
        .card:hover{
            transform:translateY(-4px);
            box-shadow:0 20px 42px rgba(93,69,95,.18);
        }

        .btn-detail{
            margin-top:10px;
            display:inline-flex;
            padding:10px 14px;
            border-radius:12px;
            background:linear-gradient(135deg,var(--c1),var(--c2));
            color:#fff !important;
            font-weight:700;
        }

        .flash,
        .error-block,
        .invalid-feedback,
        .bg-red-100{
            border-radius:16px;
            padding:14px 16px;
            margin:0 0 18px 0;
        }
        .flash-success{
            background:rgba(109,121,136,.16);
            border:1px solid rgba(109,121,136,.28);
            color:#33404c;
        }
        .flash-error,
        .error-block,
        .bg-red-100{
            background:rgba(141,95,114,.13);
            border:1px solid rgba(141,95,114,.24);
            color:#6c3c50;
        }
        .invalid-feedback{padding:8px 0 0 0; background:none; border:none; color:#8d3e5b}

        form{
            width:100%;
        }
        label{
            display:block;
            margin-bottom:8px;
            font-weight:700;
            color:var(--c1);
        }

        .form-control,
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="time"],
        input[type="number"],
        select,
        textarea{
            width:100%;
            border:1px solid rgba(93,69,95,.18);
            background:rgba(255,255,255,.82);
            color:var(--text);
            border-radius:14px;
            padding:13px 14px;
            font-size:1rem;
            transition:border-color .2s ease, box-shadow .2s ease, transform .2s ease;
        }
        .form-control:focus,
        input:focus,
        select:focus,
        textarea:focus{
            border-color:var(--c2);
            box-shadow:0 0 0 4px rgba(137,111,140,.16);
            outline:none;
        }
        textarea{min-height:140px; resize:vertical}

        .form-row{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:18px;
            margin-bottom:18px;
        }
        .form-group{min-width:0}
        .pasakumi-container,
        .surface,
        .auth-card{
            padding:28px;
            background:rgba(255,255,255,.72);
            border:var(--border);
            border-radius:var(--radius-xl);
            box-shadow:var(--shadow);
        }
        .pasakumi-form{margin-top:18px}
        .required-star{color:#8d5f72}
        .form-actions{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
            margin-top:26px;
        }

        .table-wrap{
            overflow:auto;
            padding:14px;
            margin-top:18px;
        }
        table{
            width:100%;
            border-collapse:separate;
            border-spacing:0;
            overflow:hidden;
            border-radius:18px;
            background:rgba(255,255,255,.86);
        }
        th{
            background:linear-gradient(135deg,var(--c1),var(--c6));
            color:#fff;
            font-size:.95rem;
            letter-spacing:.02em;
        }
        th,td{
            padding:14px 12px;
            border-bottom:1px solid rgba(93,69,95,.08);
            vertical-align:middle;
        }
        td{color:#4b4251}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:rgba(169,165,186,.10)}

        .max-w-md{max-width:560px;margin:0 auto}
        .mx-auto{margin-left:auto;margin-right:auto}
        .px-4,.py-8{padding:0!important}
        .text-center{text-align:center}
        .text-2xl{font-size:2rem}
        .font-bold{font-weight:700}
        .block{display:block}
        .w-full{width:100%}
        .rounded-lg{border-radius:var(--radius-xl)}
        .leading-tight{line-height:1.4}
        .focus\:outline-none:focus{outline:none}
        .flex{display:flex}
        .items-center{align-items:center}
        .justify-between{justify-content:space-between}
        .gap-2{gap:8px}

        .event-details-card{
            max-width:860px !important;
            margin:0 auto;
            padding:28px !important;
            color:var(--text) !important;
            background:rgba(255,255,255,.8) !important;
        }

        .footer{
            margin-top:auto;
            border-top:1px solid rgba(93,69,95,.12);
            background:rgba(255,255,255,.46);
        }
        .footer-inner{
            padding:18px 0 28px 0;
            color:#6e6472;
            text-align:center;
        }

        .page-heading{
            margin-bottom:18px;
        }
        .page-heading h1{
            margin-bottom:6px;
        }
        .page-heading p{
            margin:0;
            color:#645a69;
        }

        @media (max-width: 980px){
            .row,
            .form-row{
                grid-template-columns:1fr;
            }
            .header-inner{
                align-items:flex-start;
            }
            .user-panel{
                width:100%;
                justify-content:flex-start;
            }
        }

        @media (max-width: 700px){
            .header-inner, .page-wrap, .footer-inner{
                width:min(100% - 22px, 1240px);
            }
            .hero-panel, .jumbotron, .pasakumi-container, .auth-card, .event-details-card, .card{
                padding:22px;
            }
            .nav-links{
                justify-content:flex-start;
            }
            .btn, button{
                width:auto;
            }
        }
    </style>
</head>
<body>
<div class="site-shell">
    <header class="site-header">
        <div class="header-inner">
            <div class="brand">
                <div class="brand-mark"></div>
                <div class="brand-text">
                    <strong>Bibliotēkas pasākumu uzskaite</strong>
                </div>
            </div>

            <nav class="nav-links">
                @auth
                    <a href="/" class="nav-link">Sākumlapa</a>
                    <a href="/pasakumi" class="nav-link">Pasākumi</a>
                    @if(auth()->user()->loma !== 'Lietotajs')
                        <a href="/telpas" class="nav-link">Telpas</a>
                        <a href="/lietotaji" class="nav-link">Lietotāji</a>
                        <a href="/rezerveskopijas" class="nav-link">Rezerves kopijas</a>
                        <a href="/kategorijas" class="nav-link">Kategorijas</a>
                        <a href="/jaunumi" class="nav-link">Jaunumi</a>
                    @endif
                @else
                    <a href="/" class="nav-link">Sākums</a>
                @endauth
            </nav>

            <div class="user-panel">
                @if(auth()->check())
                    <div class="user-chip">
                        {{ auth()->user()->vards }} {{ auth()->user()->uzvards }} · {{ auth()->user()->loma }}
                    </div>
                    <form method="POST" action="/logout" style="margin:0;">
                        @csrf
                        <button class="btn secondary" type="submit">Izrakstīties</button>
                    </form>
                @else
                    <a href="/login" class="btn">Ielogoties</a>
                    <a href="/register" class="btn secondary">Reģistrēties</a>
                @endif
            </div>
        </div>
    </header>

    <main class="page-wrap">
        <div class="main-panel">
            @yield('content')
        </div>

        @hasSection('sidemenu')
            <aside>
                @yield('sidemenu')
            </aside>
        @endif
    </main>

    <footer class="footer">
        <div class="footer-inner">
            © {{ date('Y') }} Bibliotēkas pasākumu uzskaite. Visas tiesības aizsargātas. 
        </div>
    </footer>
</div>
</body>
</html>