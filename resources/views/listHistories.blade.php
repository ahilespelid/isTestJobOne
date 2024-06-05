<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>

        <!-- Styles -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <table>
            <thead>
                <tr>
                    <th>
                        <a href="?sortby=id&order={{ $order }}">
                        ID
                        </a>
                    </th>
                    <th>
                        <a href="?sortby=model_id&order={{ $order }}">
                        ID MODEL
                        </a>
                    </th>
                    <th>
                        <a href="?sortby=model_name&order={{ $order }}">
                        MODEL
                        </a>
                    </th>
                    <th>
                        <a href="?sortby=action&order={{ $order }}">
                        ACTION
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($histories as $historie)
                    <tr>
                        <td>{{ $historie['id']          }}</td>
                        <td>{{ $historie['model_id']    }}</td>
                        <td>{{ $historie['model_name']  }}</td>
                        <td>{{ $historie['action']      }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
