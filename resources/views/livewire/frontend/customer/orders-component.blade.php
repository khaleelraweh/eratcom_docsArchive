<div x-data="{ showOrder: @entangle('showOrder') }">
    <div class="d-flex">
        <h2 class="h5 text-uppercase mb-4">{{ __('transf.txt_orders') }}</h2>
    </div>



    <div class="my-4">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('transf.txt_order_ref') }}</th>
                        <th>{{ __('transf.txt_order_total') }}</th>
                        <th>{{ __('transf.txt_order_status') }}</th>
                        <th>{{ __('transf.txt_order_date') }}</th>
                        <th class="col-2">{{ __('transf.txt_order_action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr wire:key="{{ $order->id }}">
                            <td>{{ $order->ref_id }}</td>
                            {{-- <td>{{ $order->currency() . ' ' . $order->total }}</td> --}}
                            <td>{{ currency_converter($order->total) }}</td>
                            <td>{!! $order->statusWithLabel() !!}</td>
                            <td>{{ $order->created_at->format('d-m-Y') }}</td>
                            <td class="text-right">
                                <button type="button" wire:click="displayOrder('{{ $order->id }}')"
                                    x-on:click="showOrder = true" class="btn btn-success btn-sm">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <p class="text-center">{{ __('transf.txt_no_order_found') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div x-show="showOrder" x-on:click.away="showOrder=false" class="border rounded shadow p-4">
            <div class="table-responsive mb-4">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0" scope="col"><strong
                                    class="text-small text-uppercase">{{ __('transf.txt_course') }}</strong></th>
                            <th class="border-0" scope="col"><strong
                                    class="text-small text-uppercase">{{ __('transf.txt_course_price') }}</strong>
                            </th>
                            <th class="border-0" scope="col"><strong
                                    class="text-small text-uppercase">{{ __('transf.txt_course_quantity') }}</strong>
                            </th>
                            <th class="border-0" scope="col"><strong
                                    class="text-small text-uppercase">{{ __('transf.txt_course_total') }}</strong>
                            </th>
                        </tr>
                    </thead>
                    <tbody>


                        @if ($order_show)

                            @foreach ($order_show->courses as $product)
                                <tr>
                                    <td>{{ $product->title }}</td>
                                    {{-- <td>{{ $order->currency() . ' ' . number_format($product->price, 2) }}</td> --}}
                                    <td>{{ currency_converter($product->price) }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    {{-- <td>{{ $order->currency() . ' ' . number_format($product->price * $product->pivot->quantity, 2) }} --}}
                                    <td>{{ currency_converter($product->price * $product->pivot->quantity) }}</td>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- totals --}}

                            <tr class="total-group">
                                <td colspan="3" class="text-end">
                                    <strong>{{ __('transf.txt_course_subtotal') }}</strong>
                                </td>
                                <td>{{ currency_converter($order_show->subtotal) }}</td>
                            </tr>

                            @if (!is_null($order->offer_discount))
                                <tr class="total-group">
                                    <td colspan="3" class="text-end">
                                        <strong>{{ __('transf.txt_course_offer_discount') }}</strong>
                                    </td>
                                    <td>{{ currency_converter($order_show->offer_discount) }}</td>
                                </tr>
                            @endif

                            @if (!is_null($order->discount_code))
                                <tr class="total-group">
                                    <td colspan="3" class="text-end">
                                        <strong>{{ __('transf.txt_course_coupon_discount') }}
                                            ({{ $order->discount_code }})</strong>
                                    </td>

                                    <td>{{ currency_converter($order_show->discount) }}</td>
                                </tr>
                            @endif

                            <tr class="total-group">
                                <td colspan="3" class="text-end">
                                    <strong>{{ __('transf.txt_course_tax') }}</strong>
                                </td>
                                {{-- <td>{{ $order->currency() . ' ' . number_format($order_show->tax, 2) }}</td> --}}
                                <td>{{ currency_converter($order_show->tax) }}</td>
                            </tr>

                            <tr class="total-group total-amount">
                                <td colspan="3" class="text-end">
                                    <strong>{{ __('transf.txt_course_amount') }}</strong>
                                </td>
                                {{-- <td>{{ $order->currency() . ' ' . number_format($order_show->total, 2) }}</td> --}}
                                <td>{{ currency_converter($order_show->total) }}</td>
                            </tr>

                        @endif

                    </tbody>
                </table>
            </div>

            <!-- Transactions Table  -->
            <h2 class="h5 text-uppercase">{{ __('transf.txt_transactions') }}</h2>

            <div class="table-responsive mb-4">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0" scope="col"><strong
                                    class="text-small text-uppercase">{{ __('transf.txt_transaction') }}</strong></th>
                            <th class="border-0" scope="col"><strong
                                    class="text-small text-uppercase">{{ __('transf.txt_transaction_date') }}</strong>
                            </th>
                            {{-- <th class="border-0" scope="col"><strong class="text-small text-uppercase">Days</strong></th> --}}
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- check if order_show is set before click or not  --}}
                        @if ($order_show)
                            @foreach ($order_show->transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->status($transaction->transaction) }}</td>
                                    <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                                    {{-- <td>{{ \Carbon\Carbon::now()->addDays(5)->diffInDays($transaction->created_at->format('Y-m-d')) }}</td> --}}
                                    <td>
                                        @if (
                                            $loop->last &&
                                                $transaction->transaction == \App\Models\OrderTransaction::FINISHED &&
                                                \Carbon\Carbon::now()->addDays(5)->diffInDays($transaction->created_at->format('Y-m-d')) != 0)
                                            <button type="button"
                                                wire:click="requestReturnOrder('{{ $order->id }}')"
                                                class="btn btn-link text-right">
                                                you can return order in
                                                {{ 5 - $transaction->created_at->diffInDays() }} days
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
