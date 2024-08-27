<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json;charset=utf-8');
class dbConnect extends PDO
{
    public function __construct()
    {

        try {
            parent::__construct("mysql:host=localhost;dbname=mojavaz", "root", "");
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {

            myRestAPI::response(null, 400, "Error On DB connection." . $e->getMessage());
            exit;
        }
    }
}

class myRestAPI
{

    public $codeMelli;

    public function __construct()
    { 
       
    if (isset($_GET['codemelli'])) {
            $this->codeMelli = strtolower(htmlspecialchars($_GET['codemelli']));
            $this->Select();
        } else {
            $this->response(null, 400, "Invalid Request , Please set codeMelli. !");
        }
    }
    static function response($data, $response_code, $response_desc)
    {
        $response['data'] = $data;
        $response['responseCode'] = $response_code;
        $response['responseDesc'] = $response_desc;
        $json_response = json_encode($response, JSON_UNESCAPED_UNICODE);
        echo $json_response;
    }
    function Select()
    {
        $dbObj = new dbConnect();
        $result = array();
        $myquery = "select * from mojaveztype INNER JOIN mojavez on mojaveztype.codeMojavez = mojavez.codeMojavez 
where mojavez.postalCode IN (select address.postalCode from address INNER JOIN person ON address.codeMelli = person.codeMelli WHERE address.codeMelli={$this->codeMelli}) and mojavez.Status=1
ORDER BY mojavez.verifyDate DESC";
        $data = $dbObj->prepare($myquery);
        $data->execute();

        if ($data->rowCount() > 0) {
            $result;
            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
                $result[] = ($row);
            }
            $this->response($result, 200, "successfull");
        } else {
            $this->response(null, 200, "No any record!");
        }
    }
}

// Call and initiate API
$objAPI = new myRestAPI();
