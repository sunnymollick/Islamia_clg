<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h6 class="text-info text-center">Invoice</h6>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bill->billDetails  as $key => $billDetail)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $billDetail->incomeHead->name }}</td>
                        <td>{{ $billDetail->payable }}</td>
                        <td>{{ $billDetail->is_paid == 1 ? 'Paid' : 'Not Paid'}}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th scope="row">Total Paid</th>
                    <th colspan="3" class="text-center">{{ $bill->transaction->paid }}</th>
                </tr>
                <tr>
                    <th scope="row">Total Due</th>
                    <th colspan="3" class="text-center">{{ $bill->transaction->due }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>