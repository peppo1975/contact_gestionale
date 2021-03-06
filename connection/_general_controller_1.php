<? session_start(); ?>
<?php



abstract class TypeCountDate
{



    const Anni = 0;
    const Mesi = 1;
    const Giorni = 2;

}



class General
{



    public $conn;
    public $xlsx_library = __DIR__ . '/../my/plugins/excel/PHPExcel-1.8.1/Classes/PHPExcel/IOFactory.php';


    function __construct()
    {
        include __DIR__ . '/../connection/database.php';

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error)
        {
            die("Connection failed: " . $this->conn->connect_error);
        }

    }









    /*     * ****************** DATABASE *************************** */


    public function insert_into($table, $values, $last_id = false)
    {

        /* $last_id = true → in uscita da l'id dell'ultimo inserimento */

        $key_expl = array();

        $values_expl = array();

        $res = array();


//        foreach ($array_values as $index => $values)
//        {
        $temp = array();

        foreach ($values as $key => $value)
        {
            $key_expl[$key] = "`{$key}`";

            $insert_value = addslashes($value);

            if ($insert_value == '')
            {
                //$temp[] = 'NULL';
                unset($key_expl[$key]);
            }
            else
            {
                $temp[] = sprintf("'%s'", $insert_value);
            }
        }

        $values_expl[] = sprintf("(%s)", implode(",", $temp));
//        }

        $keys = implode(", ", $key_expl);

        $values = implode(",", $values_expl);

        /* INSERIMENTO */

        $res = $this->inserimento($table, $key_expl, $values_expl, $last_id);


        return $res;

    }









    private function inserimento($table, $key_expl, $values_expl, $last_id)
    {
        $conn = $this->conn;

        $res = array();

        $res['table'] = $table;

        $keys = implode(", ", $key_expl);
        $values = implode(",", $values_expl);


        $sql = "INSERT INTO {$table} ($keys) VALUES {$values};";

        if ($conn->query($sql) === TRUE)
        {
            if ($last_id)
            {
                $res['last_id'] = $conn->insert_id;
            }
            $res['insert'] = 1;
            $res['message'] = "OK";
        }
        else
        {
            $res['insert'] = 0;
            $res['message'] = "Error: " . $sql . "<br>" . $conn->error;
            //$this->write_file("_error_insert.txt", $res['message']);
        }

        return $res;

    }









    public function select($sql)
    {
        $conn = $this->conn;

        $res = array();

        $result = $conn->query($sql);

        if (!isset($result->num_rows))
        {
            return $res;
        }

        if ($result->num_rows > 0)
        {
            // output data of each row
            while ($row = $result->fetch_assoc())
            {
                foreach ($row as $key => $value)
                {
                    $row[$key] = stripslashes($value); /* rimuove gli slash */
                }

                $res[] = $row;
            }
        }
        else
        {
            //echo "0 results";
        }

        return $res;

    }









    public function edit($table, $array_values, $filter, $value_filter)
    {
        $conn = $this->conn;

        $values_expl = array();

        foreach ($array_values as $key => $value)
        {
            $values_expl[] = sprintf("%s = '%s'", $key, addslashes($value));
        }

        $values = implode(", ", $values_expl);


        $sql = "
            UPDATE
                {$table}
            SET
                {$values}
            WHERE
                {$filter} = '{$value_filter}'
            ";

        $this->write_file("_sql_edit.txt", $sql);

        $res = $conn->query($sql);

        return $res;

    }









    public function my_query($sql)
    {
        $conn = $this->conn;

        $res = $conn->query($sql);

        return $res;

    }









    public function key_select($array, $key_order)
    {
        /* inserisce la chiave $id_order nella chiave dell'array */
        $res = array();

        foreach ($array as $item)
        {
            $key = $item[$key_order];

            $res[$key] = $item;
        }

        return $res;

    }









    public function write_file($name, $value)
    {
        $this->create_dir("_content");
        file_put_contents("_content/{$name}", print_r($value, true));
        /* non toccare */

    }









    public function create_dir($path)
    {
        $path_expl = explode("/", $path);

        $build_path = "";

        foreach ($path_expl as $dir)
        {
//            file_put_contents("_{$dir}.txt", print_r($build_path, true));

            if ($dir == "..")
            {
                $build_path .= "{$dir}/";
                continue;
            }

            $build_path .= "{$dir}/";

            if (is_dir($build_path))
            {
                
            }
            else
            {
                mkdir($build_path);
            }
        }

    }









    function dir_list($directory = FALSE)
    {
        $dirs = array();
        $files = array();

        if ($handle = opendir("./" . $directory))
        {
            while ($file = readdir($handle))
            {
                if (is_dir("./{$directory}/{$file}"))
                {
                    if ($file != "." & $file != "..")
                    {

//                         $dirs[] = $file;
                        $dirs[] = array('name' => $file, 'file_path' => "{$directory}{$file}");
                    }
                }
                else
                {
                    if ($file != "." & $file != "..")
                    {
//                        $files[] = $file;
                        $files[] = array('name' => $file, 'file_path' => "{$directory}{$file}");
                    }
                }
            }
        }
        closedir($handle);

        reset($dirs);
        sort($dirs);
        reset($dirs);

        reset($files);
        sort($files);
        reset($files);

        $res['files'] = $files;
        $res['dirs'] = $dirs;

        return $res;

    }









    public function parse_date($date)
    {
        $len = (int) strlen($date);

        switch ($len)
        {
            case 10:
                $expl = explode("-", $date);
                return sprintf("%s/%s/%s", $expl[2], $expl[1], $expl[0]);
                break;

            case 19:
                $expl = explode(" ", $date);
                $d = $this->parse_date($expl[0]);
                $h = $expl[1];
                return "{$d} {$h}";
                break;
        }

    }









    public function parse_date_excel_to_timestamp($date)
    {
        /* https://www.extendoffice.com/documents/excel/2473-excel-timestamp-to-date.html */

        $init_unix = 25569; /* 1970-01-01 in excel */

        $date_unix = ($date - $init_unix) * 86400;

        return date("Y-m-d", $date_unix);

    }









    public function calcola_data($date, $type_count_date, $value)
    {

        if ($date == "")
        {
            return "0000-00-00";
        }


        $date_expl = explode("-", $date);

        $Y = $date_expl[0];
        $m = $date_expl[1];
        $d = $date_expl[2];

        $plus_Y = 0;
        $plus_m = 0;
        $plus_d = 0;

        switch ($type_count_date)
        {
            case TypeCountDate::Anni:
                $plus_Y = $value;
                break;
            case TypeCountDate::Mesi:
                $plus_m = $value;
                break;
            case TypeCountDate::Giorni:
                $plus_d = $value;
                break;
        }

        $new_date = date('Y-m-d', mktime(0, 0, 0, $m + $plus_m, $d + $plus_d - 1, $Y + $plus_Y));

        return $new_date;

    }









    public function send_http_post($page, $pars)
    {

        $curlSES = curl_init();

        curl_setopt($curlSES, CURLOPT_URL, $page);

        curl_setopt($curlSES, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curlSES, CURLOPT_HEADER, false);

        curl_setopt($curlSES, CURLOPT_POST, true);

        curl_setopt($curlSES, CURLOPT_POSTFIELDS, $pars);

        curl_setopt($curlSES, CURLOPT_CONNECTTIMEOUT, 10);

        curl_setopt($curlSES, CURLOPT_TIMEOUT, 30);

        $result = curl_exec($curlSES);

        curl_close($curlSES);

        echo $result;

    }









    public function is_valid_mail($maildaverificare)
    {
        $verifica = ereg("^[^@ ]+@[^@ ]+\.[^@ \.]+$", $maildaverificare);

        return $verifica;

    }









    /* EXCEL ------------------------------ */


    public function read_vertical_xlsx($name_file)
    {
        /* solo strutture a lettura verticale */


        include_once $this->xlsx_library;

        if (!file_exists($name_file))
        {
            exit("Manca FILE {$name_file}");
        }

        $index_column = $this->create_index_column();


        $objPHPExcel = PHPExcel_IOFactory::load($name_file);

        $keys_table = array();

        $res = array();

        foreach ($index_column as $column)
        {
            $i = 0;

            $exit = false;

            do
            {
                $i++;
                $row = (string) $i;

                $key = (string) $objPHPExcel->getActiveSheet()->getCell("{$column}{$row}")->getValue(); /* valori sulla prima riga */

                switch ($column)
                {
                    case 'A':
                        /* creo l'array delle chiavi */
                        if ($key !== "")
                        {
                            $keys_table[$i] = $key;
                        }
                        else
                        {
                            $exit = true;
                        }
                        break;

                    default :

                        if ($i === 1 && $key === "")
                        {
                            $exit = true;
                            break;
                        }

                        if ($i <= count($keys_table))
                        {
                            $res["{$column}"][$keys_table[$i]] = addslashes($key);
                        }
                        else
                        {
                            $exit = true;
                        }

                        break;
                }
            }
            while (!$exit);
        }

//        $this->write_file("_atleti", $res);

        return $res;

    }









    public function read_orizzontal_xlsx($name_file)
    {
        /* solo strutture a lettura orizzontale (es gruppi newsletter) */


        include_once $this->xlsx_library;

        if (!file_exists($name_file))
        {
            exit("Manca FILE {$name_file}");
        }

        $index_column = $this->create_index_column();


        $callStartTime = microtime(true);

        $objPHPExcel = PHPExcel_IOFactory::load($name_file);

        $keys_table = array();

        $res = array();

        $row = 0;

        $last_column = '';

        $exit = false;

        do
        {
            $row++;

            foreach ($index_column as $column)
            {

                $key = (string) $objPHPExcel->getActiveSheet()->getCell("{$column}{$row}")->getValue(); /* valori sulla prima riga */

                switch ($row)
                {
                    case 1:
                        /* creo l'array delle chiavi */
                        if ($key !== "")
                        {
                            $keys_table[$column] = $key;
                            $last_column = $column;
                        }
                        else
                        {
                            //$exit = true;
                            //continue;
                        }
                        break;

                    default :

                        if ($column === 'A' && $key === "")
                        {
                            $exit = true;
                            break;
                        }

                        if (isset($keys_table[$column]) && !$exit)
                        {
                            $res["{$row}"][$keys_table[$column]] = addslashes($key);
                        }
                        else
                        {
                            //continue;
                        }

                        break;
                }
            }
        }
        while (!$exit);

        return $res;

    }









    private function create_index_column()
    {
        $res = array();

        $alphas = range('A', 'Z');

        $range[0] = "";

        $range = array_merge($range, $alphas);

        foreach ($range as $key_first => $first_value)
        {
            foreach ($alphas as $key_second => $second_value)
            {
                $res[] = "{$first_value}{$second_value}";
            }
        }

        return $res;

    }









}
