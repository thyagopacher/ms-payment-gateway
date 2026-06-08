<h1>Relatório de Pedidos</h1>

<table class="table table-bordered" border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Status</th>
        <th>Método</th>
        <th>Due Date</th>
        <th>Valor $</th>
    </tr>
    @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->status }}</td>
            <td>{{ $payment->payment_method }}</td>
            <td>{{ $payment->due_date}}</td>
            <td>{{ number_format($payment->amount, 2, ',', '.') }}</td>
        </tr>
    @endforeach
</table>
