<?php

namespace App\Models;

use mysqli;

class Model {

    protected $bd_host = DB_HOST;
    protected $port = DB_PORT;
    protected $db_name = DB_NAME;
    protected $db_user = DB_USER;
    protected $db_pass = DB_PASS;

    protected $connection;
    protected $query;
    protected $table;    

    protected $select = "*";
    protected $where, $values = [];
    protected $order_by = "";
    

    public function __construct() {
        $this->connect();
    }
    
    protected function connect() {
        $this->connection = new mysqli($this->bd_host, $this->db_user, $this->db_pass, $this->db_name);

        if($this->connection->connect_error) {
            die("Error to connect data base" . $this->connection->connect_error);
        }
    }

    /**
     * Query.
     */
    protected function query($sql, $data = [], $params = null) {
        if($data) {
            if($params == null) {
                $params = str_repeat("s", count($data));
            }

            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param($params, ...$data);
            $stmt->execute();
            $this->query = $stmt->get_result();
        } else {
            $this->query = $this->connection->query($sql);
        }
        
        return $this;
    }

    /**
     * Select
     */
    public function select(...$columns) {
        $this->select = implode(", ", $columns);
        return $this;
    }

    /**
     * Find by filter.
     */
    public function where($column, $operator, $value = null) {
        if($value == null) {
            $value = $operator;
            $operator = "=";
        }

        if($this->where) {
            $this->where .= " AND {$column} {$operator} ?";
        } else {
            $this->where = "{$column} {$operator} ?";
        }

        $this->values[] = $value;
        
        return $this;
    }

    /**
     * Order by.
     */
    public function orderBy($column, $order = "ASC") {
        if($this->order_by) {
            $this->order_by .= ", {$column} {$order}";            
        } else {
            $this->order_by = " ORDER BY {$column} {$order}";            
        }
        
        return $this;
    }
    
    /**
     * First.
     */
    public function firts() {
        if(empty($this->query)) {
            $sql = "SELECT {$this->select} FROM {$this->table}";
            if($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if($this->order_by) {
                $sql .= " ORDER BY {$this->order_by}";
            }

            $this->query($sql, $this->values);            
        }
        
        return $this->query->fetch_assoc();
    }

    /**
     * Get.
     */
    public function get() {
        if(empty($this->query)) {
            $sql = "SELECT {$this->select} FROM {$this->table}";
            if($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if($this->order_by) {
                $sql .= " ORDER BY {$this->order_by}";
            }

            $this->query($sql, $this->values);            
        }

        return $this->query->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Paginate.
     */
    public function paginate($size = 15) {
        $page = isset($_GET["page"]) ? $_GET["page"]: 1;

        if(empty($this->query)) {
            $sql = "SELECT SQL_CALC_FOUND_ROWS {$this->select} FROM {$this->table}";
            
            if($this->where) {
                $sql .= " WHERE {$this->where}";
            }

            if($this->order_by) {
                $sql .= " ORDER BY {$this->order_by}";
            }
            
            $sql .= " LIMIT " . ($page - 1) * $size . ",{$size}";

            $data = $this->query($sql, $this->values)->get();            
        }
        
        $total = $this->query("SELECT FOUND_ROWS() as total")->firts()["total"];        
        $uri = $_SERVER["REQUEST_URI"];
        $uri = trim($uri, "/");
        if(strpos($uri, "?")) {
            $uri = substr($uri, 0, strpos($uri, "?"));
        }

        $path_page = "/" . $uri . "?page=";
        $prev_page = $page > 1 ? $path_page . $page - 1 : null;
        $last_page = ceil($total / $size);
        $next_page = $page < $last_page ? $path_page . $page + 1 : null;
        
        return [            
            "total" => $total,
            "begin" => ($page - 1) * $size + 1,
            "end" => ($page - 1) * $size + count($data),
            "current_page" => $page,
            "last_page" => $last_page,
            "prev_page" => $prev_page,
            "next_page" => $next_page,
            "data" => $data
        ];
    }

    /**
     * Find by id.
     */
    public function findById($id) {
        $sql = "select * from {$this->table} where id = ?";
        return $this->query($sql, [$id], "i")->firts();
    }

    /**
     * Find all.
     */
    public function findAll() {
        $sql = "SELECT * FROM {$this->table}";

        return $this->query($sql)->get();
    }    

    /**
     * Save.
     */
    public function save($data) {
        $columns = implode(", ", array_keys($data));
        $values = array_values($data);
        $sql = "insert into {$this->table} ({$columns}) values (" . str_repeat('?, ', count($values)-1) . "?)";
        $this->query($sql, $values);
                
        $insert_id = $this->connection->insert_id;
        return $this->findById($insert_id);
    }

    /**
     * Update.
     */
    public function update($id, $data) {
        $fields = [];
        foreach($data as $key => $value) {
            $fields[] = "{$key} = ?";
        }
        $fields = implode(", ", $fields);        

        $sql = "update {$this->table} set {$fields} where id = ?";
        $values = array_values($data);
        $values[] = $id;
        
        $this->query($sql, $values);
        return $this->findById($id);
    }
    
    /**
     * Delete
     */
    public function delete($id) {
        $sql = "delete from {$this->table} where id = ?";
        $this->query($sql, [$id], "i");
    }
}

?>