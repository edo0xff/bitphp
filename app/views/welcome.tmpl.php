<html>
<head>
    <title>BitPHP Framework</title>
    <meta charset="utf-8">
    <style type="text/css">
        html, body, section {
            width: 100%;
            height: 100%;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
        }
        .table {
            display: table;
            table-layout: fixed;
            height: 100%;
            width: 100%;
            padding: 0;
            margin: 0;
        }
        .cell {
            display: table-cell;
        }
        .vertical-middle {
            vertical-align: middle;
        }
        .sheet {
            padding: 15px 20px;
            background-color: #fff !important;
            color: #4A4A4A;
        }
        .sheet p {
            text-align: justify;
        }
        .sheet h4, .sheet h3, .sheet h2, .sheet h1 {
            text-align: center;
        }
        span.inline-comment {
            font-style: italic;
            color: gray;
            border-left: solid 2px rgb(3, 136, 45);
            padding: 10px 15px;
        }
        a {
            text-decoration: none;
            color: rgb(134, 134, 239);
        }
    </style>
</head>
<body>
    <div class="table" align="center">
        <div class="cell vertical-middle">
            <div class="container">
                <div class="sheet" align="left">
                    <h4>¡BitPHP está listo!</h4>
                    <p>
                        Esta es una <i>aplicación de prueba</i>, puedes quitarla ejecutando:
                    </p><br>
                    <span class="inline-comment">
                        $ cd {{ $dir }}
                    </span>
                    <br>
                    <span class="inline-comment">
                        $ php dummy remove
                    </span>
                    <br><br>
                    <p>
                        <a href="http://bitphp.root404.com/docs">Leer documentación &raquo;</a>
                    </p>
                </div>  
                <p>
                    <a href="http://root404.com/page/bitphp" target="__blank">Root404 Co.</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>