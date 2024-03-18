<?php

namespace App\Livewire\Fixtures;

use App\Models\Fixtures\Fixture;
use Livewire\Component;

class FixturesIndex extends Component
{
    public $active_view = "fixtures";

    public function toggleActiveView($value) {
        $this->active_view = $value;
    }

    public function render()
    {
        $fixtures = Fixture::upcoming()->get();
        $results  = Fixture::results()->get();

        return view('livewire.fixtures.fixtures-index', [
            'fixtures' => $fixtures,
            'results' => $results,
        ]);
    }

}
