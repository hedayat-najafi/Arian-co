
<?php
/*
Practice #1 / PHP
*/

$obj = new myAPI();
$obj->get_api_result();

class myAPI
{
    private $InputCity = "";

    private const validCites = ['zanjan', 'tehran', 'ardabil', 'isfahan', 'qazvin'];

    private const api_url = 'https://my.arian.co.ir/bpmsback/api/1.0/arian/arian/exercise/product-prices';
    public function __construct()
    {

        // Check city url parameter is set and is valid!
        if (isset($_GET['city']) && $_GET['city'] != "" && array_search(strtolower(htmlspecialchars($_GET['city'])), self::validCites) !== false) {
            $this->InputCity = strtolower(htmlspecialchars($_GET['city']));
        } else {
            echo "Invalid city.";
            exit;
        }
    }
    public function SugestSeller($response)
    {
        $sum = 0;
        $sugest = "";
        $total = 0;
        // calc requier data inside foreach
        foreach ($response as  $value) {
            if (isset($value['price'])) {
                // calc sum of price
                $sum += (int) $value['price'];
                // shipping value will be Zero in same city
                $total_temp  =  (strtolower($value["city"]) === $this->InputCity) ? $value['price'] : (int)$value['price'] + (int)$value['shipping'];
                if ((int)$total === 0) $total = $total_temp; // init $total 
                // check total price for sugest better item
                if ((int)$total_temp < (int)$total  &&  (strtolower($value["city"]) === $this->InputCity)) {
                    $sugest = " store: " . $value['store'] . " , price: " . $value['price'] . " , city : " . $value['city'] . " , shipping: " . $value['shipping'];
                    $total = $total_temp;
                }
            }
        }

        //prepare text of sugest
        date_default_timezone_set("Asia/Tehran");
        $txtResult = date("Y-m-d h:i:s") . " AVG = [" . $sum / count($response) . "]  sugest:[ " . $sugest . "]";
        $this->WriteToFile($txtResult); // call this Fn for write to file
    }
    // Function for write file
    function WriteToFile($result)
    {
        try {
            $myfile = fopen("result.txt", "a") or die("Unable to open file!");
            fwrite($myfile, $result . "\n");
            fclose($myfile);
            echo "Succesfull";
        } catch (Exception $e) {
            echo "Unable to write file!" . $e->getMessage();
        }
    }
    function get_api_result()
    {
        try {
            // featch the API data                
            $urli = curl_init(self::api_url);
            curl_setopt($urli, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($urli, CURLOPT_HTTPHEADER, array(
                'Referer: https://my.arian.co.ir/',
                'Content-Type: application/json'
            ));

            $response = curl_exec($urli);
            $httpCode = curl_getinfo($urli, CURLINFO_HTTP_CODE);
            $response = json_decode($response, true);
            curl_close($urli);
            //check response is OK or NO !
            if ((int) $httpCode === 200 && !isset($response["result"]) && count($response) > 0) {
                $this->SugestSeller($response);
            } else {
                //return bad request code
                echo "Bad reguest!";
                exit;
            }
        } catch (Exception $e) {
            //catch error
            echo  $e->getMessage();
        }
    }
}
