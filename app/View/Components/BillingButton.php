<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BillingButton extends Component
{
    public $class = "";
    public $stripeKey = "";


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class="")
    {
        $this->class = $class;
        $this->stripeKey = config('cashier.key');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.billing-button');
    }
}
