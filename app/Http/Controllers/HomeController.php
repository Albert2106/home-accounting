<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $accountingModel;
    protected $categoryModel;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Accounting $accountingModel, Category $categoryModel)
    {
        $this->middleware('auth');
        $this->accountingModel = $accountingModel;
        $this->categoryModel = $categoryModel;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $accountings = $this->accountingModel->getItems();
        $incomeCount = $this->accountingModel->getCount(1);
        $expensesCount = $this->accountingModel->getCount(2);
        $categoryIncomes = $this->categoryModel->getCategories(1);
        $categoryExpenses = $this->categoryModel->getCategories(2);

        return view('home', compact(
            'accountings',
            'expensesCount',
            'incomeCount',
            'categoryIncomes',
            'categoryExpenses'));
    }

    public function store(Request $request)
    {
        $AddSelf = new Accounting();

        $AddSelf->type = $request['type'];
        $AddSelf->category_id = $request['category_id'];
        $AddSelf->amount = $request['amount'];
        $AddSelf->comment = $request['comment'];

        $AddSelf->save();

        return back();
    }

    public function delete($id)
    {
        Accounting::destroy($id);
        return back();
    }

}
