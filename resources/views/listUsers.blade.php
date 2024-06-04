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
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </th>
                    <th>
                        <a href="?sortby=id&order={{ $order }}">
                        ID
                        </a>
                    </th>
                    <th>
                        <a href="?sortby=id&order={{ $order }}">
                        LAST NAME
                        </a>
                    </th>
                    <th>
                        <a href="?sortby=id&order={{ $order }}">
                        NAME
                        </a>
                    </th>
                    <th>
                        <a href="?sortby=id&order={{ $order }}">
                        MIDDLE NAME
                        </a>
                    </th>
                    <th>
                        <a href="?sortby=model_id&order={{ $order }}">
                        EMAIL
                        </a>
                    </th>
                    <th>
                        <a href="?sortby=model_name&order={{ $order }}">
                        PHONE
                        </a>
                    </th>
                    <th>
                        <a href="?sortby=action&order={{ $order }}">
                        DELETED
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $userIteration => $user)
                    <tr>
                        <td>{{ ++$userIteration  }}</td>
                        <td>{{ $user['id']          }}</td>
                        <td>{{ $user['last_name']   }}</td>
                        <td>{{ $user['name']        }}</td>
                        <td>{{ $user['middle_name'] }}</td>
                        <td>{{ $user['email']       }}</td>
                        <td>{{ $user['phone']       }}</td>
                        <td>{{ $user['deleted_at']  }}</td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    </body>
</html>
