<?php
require_once '../conexion/db.php';
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET NAMES 'utf8'");
$sql = "
  SELECT 
    n.id_nota,
    u.nombre_usuario,
    m.nombre_materia,
    n.nota1,
    n.nota2,
    n.nota3
  FROM notas AS n
  JOIN usuarios AS u ON n.id_usuario = u.id_usuario
  JOIN materias AS m ON n.id_materia = m.id_materia
";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$notas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Notas</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/831/831373.png">

    <style>
        body {
            height: 100%;
            width: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background:
                linear-gradient(rgba(6, 46, 0, 0.9), rgba(6, 46, 0, 0.9)),
                url('https://ehq-production-us-california.imgix.net/8e99a9b5c3a7d7b7f21e4de60a1590a0047dc1a0/original/1597455791/blob_acf9e3dc0f4ce2f2ab4688246c4305a2?auto=compress%2Cformat&w=1080') center/cover no-repeat fixed;
        }

        table {
            background-color: #00ab39ff;
            border-radius: 0.375rem;
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            color: white;
        }

        thead tr {
            background-color: #0cd16fff;
            color: white;
        }

        th,
        td {
            padding: 0.75rem 1rem;
            text-align: left;
            vertical-align: middle;
        }

        tbody tr:nth-child(even) {
            background-color: #03e547ff;
        }

        tbody tr:nth-child(odd) {
            background-color: #02d140ff;
        }

        tbody tr:hover {
            background-color: #02bd18ff;
            cursor: pointer;
        }

        .dataTables_wrapper {
            color: #000;
        }

        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_info {
            color: #fff !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
            color: #fff !important;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background-color: #81faa7ff;
            color: #000;
            border: 1px solid #02d15fff;
            border-radius: 0.25rem;
            padding: 0.3rem 0.5rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background-color: #03f45bff;
            color: #000 !important;
            border-radius: 0.25rem;
            margin: 0 2px;
            padding: 0.3rem 0.6rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #02d14bff !important;
            color: white !important;
        }

        .modal-bg {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            width: 90%;
            max-width: 360px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .modal-card h2 {
            margin-bottom: 1rem;
            color: #C62828;
            text-align: center;
            font-weight: bold;
        }

        .modal-group {
            margin-bottom: 1rem;
            text-align: left;
        }

        .modal-group label {
            display: block;
            font-weight: bold;
            margin-bottom: .25rem;
        }

        .modal-group input {
            width: 100%;
            padding: .5rem;
            border: 1px solid #C62828;
            border-radius: 4px;
        }

        .modal-close {
            position: absolute;
            top: .5rem;
            right: .5rem;
            background: transparent;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: #999;
        }

        .btn-din {
            display: inline-block;
            margin: .5rem;
            padding: .8rem 1.5rem;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background: linear-gradient(45deg, #28c62dff, #21b71cff);
            border: 2px solid transparent;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: transform .2s, background .5s;
            cursor: pointer;
            width: calc(48% - 1rem);
            max-width: 200px;
        }

        .btn-din:hover {
            transform: scale(1.05);
            background: linear-gradient(45deg, #32a410ff, #1c950eff);
            border-color: #fff;
        }

        .titulo {
            color: #fff;
            text-shadow: 2px 2px 1px rgba(0, 255, 94, 0.72);
        }

        .aceptarEliminar {
            background: linear-gradient(45deg, #b31f1fff, #aa1717ff);
        }

        .aceptarEliminar:hover {
            background: linear-gradient(45deg, #950f0fff, #770b0bff);
        }

        .btn-dino {
            display: inline-block;
            padding: .8rem 1.5rem;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background: linear-gradient(45deg, #b31f1fff, #aa1717ff);
            border: 2px solid transparent;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: transform .2s, background .5s;
            cursor: pointer;
            width: 100%;
            max-width: 200px;
        }

        .btn-dino:hover {
            transform: scale(1.05);
            background: linear-gradient(45deg, #950f0fff, #770b0bff);
            border-color: #fff;
        }

        #btn-volver {
            position: fixed;
            top: 15px;
            left: 15px;
            width: 105px;
            background: linear-gradient(45deg, #C62828, #B71C1C);
            color: #fff;
            border: none;
            padding: .6rem 1rem;
            background: linear-gradient(45deg, #3b3b3b, #000000);
            cursor: pointer;
            z-index: 1001;
            clip-path: polygon(30% 0%, 100% 0%, 100% 100%, 30% 100%, 0% 50%);
        }

        #btn-volver span {
            margin-left: 15px;
        }

        #btn-volver:hover {
            background: linear-gradient(45deg, #646464, #353535);
        }

        .modal-card .group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .modal-card .group input,
        .modal-card .group select {
            width: 100%;
            padding: .5rem .75rem;
            border: 2px solid #C62828;
            border-radius: 4px;
            background: #fff;
            appearance: none;
            box-sizing: border-box;
            font-size: 1rem;
            line-height: 1.2;
        }

        .modal-card .group select {
            height: 2.5rem;
        }

        .modal-card .group label {
            position: absolute;
            left: .75rem;
            top: -.75rem;
            background: #fff;
            padding: 0 .25rem;
            font-size: .85rem;
            font-weight: bold;
            color: #C62828;
        }

        .dataTables_wrapper .dataTables_length select {
            width: 3.5em;
            min-width: 3.5em;
            padding: 0 0.3em 0 0.3em;
        }

        .editarPedido {
            background: linear-gradient(45deg, #e0e02fff, #d2d212ff);
        }

        .editarPedido:hover {
            background: linear-gradient(45deg, #c9c920ff, #b4b41fff);
        }

        .eliminarPedido {
            background: linear-gradient(45deg, #d82828ff, #cb1b1bff);
        }

        .eliminarPedido:hover {
            background: linear-gradient(45deg, #b31515ff, #980f0fff);
        }
    </style>
</head>

<body>
    <div class="w-full max-w-screen-xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center titulo">Lista de Notas</h1>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="notasTable" class="w-full text-sm text-left">
                <thead>
                    <tr>
                        <th class="px-6 py-3">Estudiante</th>
                        <th class="px-6 py-3">Asignatura</th>
                        <th class="px-6 py-3">N1</th>
                        <th class="px-6 py-3">N2</th>
                        <th class="px-6 py-3">N3</th>
                        <th class="px-6 py-3">Promedio</th>
                        <th class="px-6 py-3">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notas as $n):
                        $prom = ($n['nota1'] + $n['nota2'] + $n['nota3']) / 3;
                        $estado = $prom >= 14.01 ? 'Aprobado' : 'Reprobado';
                        ?>
                        <tr>
                            <td class="px-6 py-4"><?= htmlspecialchars($n['nombre_usuario']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($n['nombre_materia']) ?></td>
                            <td class="px-6 py-4"><?= number_format($n['nota1'], 2) ?></td>
                            <td class="px-6 py-4"><?= number_format($n['nota2'], 2) ?></td>
                            <td class="px-6 py-4"><?= number_format($n['nota3'], 2) ?></td>
                            <td class="px-6 py-4"><?= number_format($prom, 2) ?></td>
                            <td class="px-6 py-4"><?= $estado ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <button onclick="history.back()" id="btn-volver" class="btn-din"><span>Regresar</span></button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(() => {
            $('#notasTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50]
            });
        });
    </script>
</body>

</html>