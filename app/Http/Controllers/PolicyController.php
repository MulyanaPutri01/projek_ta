<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Takmir;

class PolicyController extends Controller
{
    public function update($id)
{
    $takmir = Takmir::findOrFail($id);

    // Check if the user is authorized to update
    $this->authorize('update', $takmir);

    // Proceed with the update logic
}
}
