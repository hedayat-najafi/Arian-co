<?php
/*
Practice #2 / PHP
*/

$obj = new MellatBank();
$obj->GetTransactions();
$obj  = new SamanBank();
$obj->GetTransactions();

abstract class Bank
{
    private string $_token;
    public function __construct()
    {
        $this->_token = $this->GetToken();
    }
    abstract public function GetToken(): string;
    final public function GetTransactions(): void
    {
        if ($this->_token === null || $this->_token === "") {
            echo "<p> Token must be set." . $this->_token . "</p>";
        } else {
            //echo $this->_token;
            if ($this instanceof MellatBank) {

                echo "<p> Mellat Bank Token : <b> {$this->GetToken()}</b></p> ";
            }
            if ($this instanceof SamanBank) {
                echo "<p> Saman Bank Token : <b> {$this->GetToken()}</b> </p>";
            }

            $filename = "bank-transaction.txt";
            $result = $this->CustomReadFile($filename);
            foreach ($result["transactions"] as $transact) {
                echo " <p> ID:" . $transact["id"] . " , Amount:" . $transact["amount"] . " , Date: " . $transact["datetime"] . "</p>";
            }
            //var_dump($result);

        }
    }
    protected function CustomReadFile(string $file)
    {
        $myfile = fopen($file, "r") or die("Unable to open file!");
        $result = json_decode(fread($myfile, filesize($file)), true);
        fclose($myfile);
        return $result;
    }
}
class MellatBank extends Bank
{
    public function GetToken(): string
    {
        $filename = "mellat-token.txt";
        $result = $this->CustomReadFile($filename);
        //var_dump($result);
        if (isset($result["result"]["data"]["access_token"])) {
            return $result["result"]["data"]["access_token"];
        }
        return "";
    }
}
class SamanBank extends Bank
{
    public function GetToken(): string
    {
        $filename = "saman-token.txt";
        $result = $this->CustomReadFile($filename);
        //var_dump($result);
        if (isset($result["token"])) {
            return $result["token"];
        }
        return "";
    }
}
