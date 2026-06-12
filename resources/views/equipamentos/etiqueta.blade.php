{{-- etiqueta.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Etiqueta - {{ $equipamento->numero_patrimonio }}</title>
    <style>
        .etiqueta {
            width: 300px;
            padding: 20px;
            border: 1px solid #000;
            text-align: center;
            font-family: monospace;
        }
        .codigo {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .descricao {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="etiqueta">
        <div>⭐ ALUGA MAIS ⭐</div>
        <div class="codigo">{{ $equipamento->numero_patrimonio }}</div>
        <div class="descricao">{{ $equipamento->nome }}</div>
        <div class="descricao">{{ $equipamento->marca }} {{ $equipamento->modelo }}</div>
    </div>
    <script>window.print();</script>
</body>
</html>