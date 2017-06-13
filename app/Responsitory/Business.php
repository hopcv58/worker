<?php

namespace App\Responsitory;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

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
    private $districts;

    /**
     * Business constructor.
     */
    public function __construct()
    {
        $this->categories = new Categories();
        $this->users = new User();
        $this->customer = new Customers();
        $this->category_level = new Category_level();
        $this->workers = new Workers();
        $this->transactions = new Transactions();
        $this->districts = new Districts();
    }

    /**
     * @return array
     */
    public function getAllWorkers()
    {
        $ids = $this->workers->select('id')->get();
        $workers = [];
        foreach ($ids as $id) {
            $workers[] = $this->getWorkerById($id->id);
        }
        return $workers;
    }

    /**
     * @param $id
     * @return mixed
     */
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

    /**
     * @param $user_id
     * @return mixed
     */
    public function getWorkerByUserId($user_id)
    {
        $worker = $this->workers->where('user_id', $user_id)->first();
        if (!isset($worker)) {
            return $worker;
        }
        $category_level = $this->category_level->select('category_id')->where('worker_id', '=', $user_id)->get();
        $worker->rate = $this->transactions->where('worker_id', '=', $user_id)->where('is_finished', '=', 1)->avg('rate');
        $jobs = [];
        $worker->feedback = $this->getFeedbackByWorkerId($user_id);
        foreach ($category_level as $cate) {
            $jobs[] = $this->getFinalParentCategory($cate->category_id);
        }
        $jobs = array_unique($jobs);
        $worker->user = $this->users->find($user_id);
        $worker->job = $jobs;
        return $worker;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function getCustomerByUserId($user_id)
    {
        $customer = $this->customer->where('user_id', $user_id)->first();
        if (!isset($customer)) {
            return $customer;
        }
        $customer->user = $this->users->find($user_id);
        return $customer;
    }

    /**
     * @param $id
     * @return mixed
     */
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

    /**
     * @param $id
     * @return mixed
     */
    public function getUserByWorkerId($id)
    {
        $worker = $this->workers->find($id);
        $user = $this->users->find($worker->user_id);
        return $user;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserByCustomerId($id)
    {
        $customer = $this->customer->find($id);
        $user = $this->users->find($customer->user_id);
        return $user;
    }

    /**
     * @return mixed
     */
    public function getAllGrandCategories()
    {
        $categories = $this->categories->where("parent_id", NULL)->get();
        foreach ($categories as $category) {
            $category->child = $this->getAllChildCategories($category->id);
        }
        return $categories;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getFinalParentCategory($id)
    {
        $category = $this->categories->select('id', 'name', 'description', 'parent_id')->where('id', '=', $id)->where('is_public', '=', 1)->first();
        $parent = $this->categories->select('name', 'description', 'parent_id')->where('id', '=', $category->parent_id)->first();
        return $parent;
    }

    /**
     * @return array
     */
    public function getAllTransactions()
    {
        $ids = $this->transactions->select('id')->get();
        $transactions = [];
        foreach ($ids as $id) {
            $transactions[] = $this->getTransactionById($id->id);
        }
        return $transactions;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTransactionById($id)
    {
        $transcation = $this->transactions->find($id);
        $transcation->worker = $this->getUserByWorkerId($transcation->worker_id);
        $transcation->customer = $this->getUserByCustomerId($transcation->customer_id);
        $transcation->category = $this->categories->find($transcation->category_id);
        return $transcation;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTransactionByCustomerId($id)
    {
        $transcations = $this->transactions->where("customer_id", "=", $id)->get();
        foreach ($transcations as $transcation) {
            if (isset($transcation->worker_id)) {
                $transcation->worker = $this->getUserByWorkerId($transcation->worker_id);
            }
            $transcation->customer = $this->getUserByCustomerId($transcation->customer_id);
            $transcation->category = $this->categories->find($transcation->category_id);
        }
        return $transcations;
    }

    /**
     * @param $id
     * @return mixed
     */
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

    /**
     * @param $request
     */
    public function saveNewWorker($request)
    {
        $this->workers->id = $request->id;
        $this->workers->customer_id = Auth::user()->id;
        $this->workers->category_id = "f15a4770-4437-11e7-a47f-54a050032ab0";
        $this->workers->address = $request->address;
        $this->workers->district_id = $this->getDistrictIdFromAddress($request->address);
        $this->workers->title = $request->title;
        $this->workers->description = $request->description;
        $this->workers->started_at = $request->start_date . " " . $request->start_time . ":00";
        $this->workers->save();
    }

    /**
     * @param $name
     * @return mixed
     */
    public function findOrCreateDistrictByName($name)
    {
        $district = $this->districts->where('name', $name)->first();
        if (!isset($district)) {
            $district->id = Uuid::generate();
            $district->name = $name;
            $district->save();
        }
        return $district;
    }

    /**
     * @param $address
     * @return mixed
     */
    public function getDistrictIdFromAddress($address)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=AIzaSyDK5wM2IT_kGYYRTGo9dVr4hRi4loDRbGg";
        $json = json_decode(file_get_contents($url), true);
        foreach ($json["results"][0]["address_components"] as $address_component) {
            if (in_array("administrative_area_level_2", $address_component["types"])) {
                return $this->findOrCreateDistrictByName($address_component["long_name"])->id;
            }
        }
    }

    /**
     * @param $request
     */
    public function saveNewTransaction($request)
    {
        $this->transactions->id = $request->id;
        $this->transactions->customer_id = Auth::user()->id;
        $this->transactions->category_id = "f15a4770-4437-11e7-a47f-54a050032ab0";
        $this->transactions->address = $request->address;
        $this->transactions->district_id = $this->getDistrictIdFromAddress($request->address);
        $this->transactions->title = $request->title;
        $this->transactions->description = $request->description;
        $this->transactions->started_at = $request->start_date . " " . $request->start_time . ":00";
        $this->transactions->save();
    }

    /**
     * @param $category_id
     * @return array
     */
    public function getAllChildCategories($category_id)
    {
        $categories = $this->categories->where('parent_id', $category_id)->get();
        return $categories;
    }
}
