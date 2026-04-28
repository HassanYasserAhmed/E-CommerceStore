<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\ImportProducts;
use Illuminate\Http\Request;

class ImportProductsController extends Controller
{
    public function create()
    {
        return view('dashboard.products.import');
    }

    public function store(Request $request)
    {
        // $this->dispatch(new ImportProducts($request->post('count')));
        $job = new ImportProducts($request->post('count'));
        $job->onQueue('import')->onConnection('database')->delay(now()->addSeconds(5));
        dispatch($job);

        return redirect()->route('products.index')->with([
            'success' => 'import is running....',
        ]);
    }
}
