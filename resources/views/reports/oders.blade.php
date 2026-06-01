<h1>Relatório de Pedidos</h1>

<table>
    @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->id }}</td>
            <td>{{ number_format($payment->amount, 2) }}</td>
        </tr>
    @endforeach
</table>
