<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<h4>
   <h4>Отчет на 24.03.2021г.</h4>
    <hr>

{{-- <h5>  ФИО сотрудника - {{$data['article']}}</h5>--}}
    <table border="1">
        <th>Сотрудник</th>
        <th>Время начало смены</th>
        <th>Время окончание смены</th>

    @foreach ($data as $item)

            <tr>
                <td> {{ $item['name'] }}</td>
                <td> {{ $item['start_time'] }}</td>
                <td> {{ $item['end_time'] }}</td>

            </tr>


        @endforeach
        </table>
</h4>


</body>
</html>
