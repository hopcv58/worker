<?php

namespace App\Responsitory;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Psy\Exception\ErrorException;
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
        $this->customers = new Customers();
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
        if (!isset($worker->rate)) {
            $worker->rate = 0;
        }
        $jobs = [];
        $worker->feedback = $this->getFeedbackByWorkerId($id);
        if (!isset($worker->feedback)) {
            $worker->back = [];
        }
        foreach ($category_level as $cate) {
            $jobs[] = $this->getParentCategory($cate->category_id);
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
            $jobs[] = $this->getParentCategory($cate->category_id);
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
        $customer = $this->customers->where('user_id', $user_id)->first();
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
        if (!isset($id)) {
            return null;
        }
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
        $customer = $this->customers->find($id);
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
    public function getParentCategory($id)
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
    public function saveNewWorker(Request $request)
    {
        $this->workers->district_id = $this->findOrCreateDistrictIdByAddress($request->address);
        $this->workers->lat = $this->getLatLngFromAddress($request->address)["lat"];
        $this->workers->lng = $this->getLatLngFromAddress($request->address)["lng"];
        $this->workers->id = $request->id;
        $this->workers->description = $request->description;
        $this->workers->address = $request->address;
        $this->workers->website = $request->website;
        $this->workers->bank_account = $request->bank_account;
        $this->workers->type = $request->type;
        $this->workers->user_id = Auth::user()->id;
        $this->workers->save();
    }

    /**
     * @param $name
     * @return mixed
     */
    public function findOrCreateDistrictIdByAddress($address)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=AIzaSyDK5wM2IT_kGYYRTGo9dVr4hRi4loDRbGg";
        $json = json_decode(file_get_contents($url), true);
        foreach ($json["results"][0]["address_components"] as $address_component) {
            if (in_array("administrative_area_level_2", $address_component["types"])) {
                $district = $this->districts->firstOrNew(['name' => $address_component["long_name"]]);
                if (!isset($district->id)) {
                    $district->id = Uuid::generate();
                    $district->name = $address_component["long_name"];
                    $district->save();
                }
                return $district->id;
            }
        }
    }

    /**
     * @param $address
     * @return mixed
     */
    public function getDistrictIdFromAddress($address)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=AIzaSyDK5wM2IT_kGYYRTGo9dVr4hRi4loDRbGg";
        $json = json_decode(file_get_contents($url), true);
        if (sizeof($json["results"]) == 0) return "";
        foreach ($json["results"][0]["address_components"] as $address_component) {
            if (in_array("administrative_area_level_2", $address_component["types"])) {
                return $this->districts->where('name', $address_component["long_name"])->first()->id;
//                return $this->findOrCreateDistrictByName($address_component["long_name"])->id;
            }
        }
    }

    /**
     * @param $request
     */
    public function saveNewTransaction(Request $request)
    {
        $path = 'images/';
        $array_image = $this->saveManyImg($request->file('img'), $path);
        $this->transactions->images = json_encode($array_image);
        $this->transactions->id = $request->id;
        $this->transactions->customer_id = $request->customer_id;
        $this->transactions->category_id = $request->category_id;
        $this->transactions->address = $request->address;
        $this->transactions->district_id = $this->findOrCreateDistrictIdByAddress($request->address);
        $this->transactions->title = $request->title;
        $this->transactions->description = $request->description;
        $this->transactions->started_at = $request->start_date . " " . $request->start_time . ":00";
        $this->transactions->save();
        return $this->transactions;
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

    public function searchChildCategoriesByName($category_id, $name)
    {
        $query = $this->categories->where('name', 'like', '%' . $name . '%');
        if ($category_id != "") {
            $query = $query->where('parent_id', $category_id);
        }
        $categories = $query->get();
        return $categories;
    }

    public function getTransactionByCategoryId($category_id)
    {
        $transactions = $this->transactions->where('category_id', '=', $category_id)->get();
        return $transactions;
    }

    public function getNewTransactionByCategoryId($category_id)
    {
        $transactions = $this->transactions->where('category_id', '=', $category_id)
            ->where('is_finished', '=', 0)->get();
        return $transactions;
    }

    public function getOldTransactionByCategoryId($category_id)
    {
        $transactions = $this->transactions->where('category_id', '=', $category_id)
            ->where('is_finished', '=', 1)->get();
        return $transactions;
    }

    public function getCategoryById($category_id)
    {
        $category = $this->categories->find($category_id);
        return $category;
    }

    public function createCustomerWithAddress($user_id, $address)
    {
        $this->customers->id = Uuid::generate();
        $this->customers->address = $address;
        $this->customers->district_id = $this->findOrCreateDistrictIdByAddress($address);
        $this->customers->user_id = $user_id;
        $this->customers->save();
        return $this->customers->id;
    }

    private function getWorkerByCategoryId($category)
    {
        $ids = $this->category_level->select('worker_id')->where('category_id', $category)->get();
        $workers = [];
        foreach ($ids as $id) {
            $workers[] = $this->getWorkerById($id->worker_id);
        }
        $workers = array_unique($workers);
        return $workers;
    }

    private function getWorkerByDistrictId($district)
    {
        $query = $this->workers->select('id');
        if (isset($district)) {
            $query = $query->where('district_id', $district);
        }
        $ids = $query->get();
        $workers = [];
        foreach ($ids as $id) {
            $workers[] = $this->getWorkerById($id->id);
        }
        return $workers;
    }

    public function getWorkerByCategoryAndDistrict($category, $district)
    {
        if (isset($category)) {
            if (isset($district)) {
                $ids = $this->workers->join('category_levels', 'workers.id', '=', 'category_levels.worker_id')
                    ->select('workers.id')->where('workers.district_id', $district)
                    ->where('category_levels.category_id', $category)->get();
                $workers = [];
                foreach ($ids as $id) {
                    $workers[] = $this->getWorkerById($id->id);
                }
                return $workers;
            } else {
                return $this->getWorkerByCategoryId($category);
            }
        } else {
            return $this->getWorkerByDistrictId($district);
        }
    }

    public function getLatLngFromAddress($address)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=AIzaSyDK5wM2IT_kGYYRTGo9dVr4hRi4loDRbGg";
        $json = json_decode(file_get_contents($url), true);
        return $json["results"][0]["geometry"]["location"];
    }

    /**
     * upload nhieu anh
     * @param array $imgs
     * @param string $path
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function saveManyImg($imgs, $path)
    {
        $names = [];
        if ($imgs == null) {
            return null;
        }
        foreach ($imgs as $img) {
            $err = null;
            $name = $img->getClientOriginalName();
            $ext = $img->getClientOriginalExtension();
            //kiem tra file trung ten
            while (file_exists($path . '/' . $name)) {
                $name = str_random(5) . "_" . $name;
            }
            $arr_ext = ['png', 'jpg', 'gif', 'jpeg'];
            if (!in_array($ext, $arr_ext)) {
                $names = null;
                return redirect()->back()->with('not_img', 'Chọn file ảnh png jpg gif jpeg có kích thước < 5Mb');
            } else {
                $img->move($path, $name);
                $names[] = $name;
            }
        }
        return $names;
    }

    public function getUserByToken($token)
    {
        return $this->users->where("remember_token", $token)->first();
    }
}
