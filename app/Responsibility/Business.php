<?php

namespace App\Responsitory;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * contain all Business logic
 * Class Business
 * @package App\Responsitory
 */
class Business // extends Model
{
    private $categories;
    private $transactions;
    private $workers;
    private $customers;
    private $category_level;
    private $users;

    public function __construct()
    {
        $this->categories = new Categories();
        $this->users = new User();
        $this->customer = new Customers();
        $this->category_level = new Category_level();
        $this->workers = new Workers();
        $this->transactions = new Transactions();
    }

    public function getAllWorkers()
    {
        $ids = $this->workers->select('id')->get();
        $workers = [];
        foreach ($ids as $id) {
            $workers[] = $this->getWorkerById($id->id);
        }
        return $workers;
    }

    public function getWorkerById($id)
    {
        $worker = $this->workers->find($id);
        $category_level = $this->category_level->select('category_id')->where('worker_id', '=', $id)->get();
        $worker->rate = $this->transactions->where('worker_id', '=', $id)->where('is_finished', '=', 1)->avg('rate');
        $jobs = [];
        $worker->feedback = $this->getFeedbackByWorkerId($id);
        foreach ($category_level as $cate) {
            $jobs[] = $this->getFinalParentCategory($cate->category_id);
        }
        $jobs = array_unique($jobs);
        $worker->user = $this->getUserByWorkerId($id);
        $worker->job = $jobs;
        return $worker;
    }

    public function getFeedbackByWorkerId($id)
    {
        $feedbacks = $this->transactions->select('feedback', 'rate', 'finished_at', 'customer_id')->where('worker_id', '=', $id)->where('is_finished', '=', 1)->get();
        foreach ($feedbacks as $feedback) {
            $customer = $this->getUserByCustomerId($feedback->customer_id);
            $feedback->customer_name = $customer->name;
            $feedback->customer_avatar = $customer->avatar_path;
        }
        return $feedbacks;
    }

    public function getUserByWorkerId($id)
    {
        $worker = $this->workers->find($id);
        $user = $this->users->find($worker->user_id);
        return $user;
    }

    public function getUserByCustomerId($id)
    {
        $customer = $this->customer->find($id);
        $user = $this->users->find($customer->user_id);
        return $user;
    }

    public function getGrandCategory()
    {
        $categories = $this->categories->where("parent_id", "NULL")->get();
        return $categories;
    }


    public function getFinalParentCategory($id)
    {
        $category = $this->categories->select('name', 'description', 'parent_id')->where('id', '=', $id)->where('is_public', '=', 1)->first();
        while ($category->parent_id != NULL) {
            $category = $this->categories->select('name', 'description', 'parent_id')->where('id', '=', $category->parent_id)->first();
        }
        return $category;
    }

    public function getAllTransactions()
    {
        $ids = $this->transactions->select('id')->get();
        $transactions = [];
        foreach ($ids as $id) {
            $transactions[] = $this->getTransactionById($id->id);
        }
        return $transactions;
    }

    public function getTransactionById($id)
    {
        $transcation = $this->transactions->find($id);
        $transcation->worker = $this->getUserByWorkerId($transcation->worker_id);
        $transcation->customer = $this->getUserByCustomerId($transcation->customer_id);
        $transcation->category = $this->categories->find($transcation->category_id);
        return $transcation;
    }

    public function getTransactionByCustomerId($id)
    {
        $transcations = $this->transactions->where("customer_id", "=", $id)->get();
        foreach ($transcations as $transcation) {
            $transcation->worker = $this->getUserByWorkerId($transcation->worker_id);
            $transcation->customer = $this->getUserByCustomerId($transcation->customer_id);
            $transcation->category = $this->categories->find($transcation->category_id);
        }
        return $transcations;
    }

    public function getTransactionByWorkerId($id)
    {
        $transcations = $this->transactions->where("worker_id", "=", $id)->get();
        foreach ($transcations as $transcation) {
            $transcation->worker = $this->getUserByWorkerId($transcation->worker_id);
            $transcation->customer = $this->getUserByCustomerId($transcation->customer_id);
            $transcation->category = $this->categories->find($transcation->category_id);
        }
        return $transcations;
    }

    public function saveNewWorker()
    {

    }
}
