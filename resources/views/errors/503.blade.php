<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>En Mantenimiento | Coralis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6f8;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 20px;
        }

        .container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            max-width: 520px;
            width: 100%;
        }

        .logo {
            width: 120px;
            margin-bottom: 20px;
        }

        .illustration {
            width: 100%;
            max-width: 300px;
            margin: 0 auto 30px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 12px;
            color: #1f2937;
        }

        p {
            font-size: 16px;
            color: #4b5563;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="container">
        <img class="logo" src="https://coralis.stylesolutionpty.com/assets/logo.png" alt="Coralis Logo" onerror="this.style.display='none'">
        
        <img class="illustration" src="https://undraw.co/api/illustrations/638f3a8f-4576-45b2-8e38-95e8b580b6ab" alt="En mantenimiento" onerror="this.style.display='none'">

        <h1>Estamos trabajando en algo increíble</h1>
        <p>El sitio se encuentra en mantenimiento temporal. Volveremos muy pronto. Gracias por tu paciencia 🙌</p>

        <div class="footer">
            &copy; {{ date('Y') }} Coralis. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>

