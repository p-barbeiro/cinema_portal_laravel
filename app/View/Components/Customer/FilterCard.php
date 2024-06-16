<?php

namespace App\View\Components\Customer;

use App\Models\Customer;
use Cassandra\Custom;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{
    public array $listPayment;

    public function __construct(
        public string  $filterAction,
        public string  $resetUrl,
        public ?string $search = null,
        public string  $searchPlaceholder = 'Search by title, nif, or email',
        public ?string  $paymentType = null
    )
    {
        $payment_type = Customer::pluck('payment_type', 'payment_type')?->toArray();
        $this->listPayment = [null => 'Any Payment'] + $payment_type;
    }
public
function render(): View
{
    return view('components.customer.filter-card');
}
}
