<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Loan & EMI Details
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Loan Details -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Loan Details</h3>
                    <table class="table-auto w-full border">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="px-4 py-2">Client ID</th>
                                <th class="px-4 py-2"># Payments</th>
                                <th class="px-4 py-2">First Payment</th>
                                <th class="px-4 py-2">Last Payment</th>
                                <th class="px-4 py-2">Loan Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loanDetails as $loan)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loan->clientid }}</td>
                                    <td class="border px-4 py-2">{{ $loan->num_of_payment }}</td>
                                    <td class="border px-4 py-2">{{ $loan->first_payment_date }}</td>
                                    <td class="border px-4 py-2">{{ $loan->last_payment_date }}</td>
                                    <td class="border px-4 py-2">{{ number_format($loan->loan_amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Process EMI Button -->
            <div class="mb-6">
                <form method="POST" action="{{ route('emi.process') }}">
                    @csrf
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                        Process EMI
                    </button>
                </form>
            </div>

            <!-- EMI Details -->
            @if(!empty($emiDetails) && count($emiDetails) > 0)
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">EMI Details</h3>
                        <table class="table-auto w-full border">
                            <thead>
                                <tr class="bg-gray-200">
                                    @foreach(array_keys((array)$emiDetails[0]) as $col)
                                        <th class="px-4 py-2">{{ $col }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($emiDetails as $row)
                                    <tr>
                                        @foreach((array)$row as $val)
                                            <td class="border px-4 py-2">{{ $val }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
