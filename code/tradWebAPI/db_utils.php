<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 15-7-8
 * Time: 下午4:47
 */
$GLOBALS['DB_ERR_CB'] = '_db_utils_default_err_cb';
class Model{

    function _db_utils_default_err_cb($db, $err)
    {
        echo $db;
        echo $err;
        die;
    }

    function _err_cb($db, $err)
    {
        $cb = $GLOBALS['DB_ERR_CB'];
        if (function_exists($cb))
            $cb($db);
        else
            _db_utils_default_err_cb($db, $err);
    }

    function _db_query($db, $sql)
    {
        if ($res = $db->query($sql))
            return $res;
        _err_cb($db, $db->error);
    }

    function _db_multi_query($db, $sql)
    {
        if ($res = $db->multi_query($sql))
            return $res;
        _err_cb($db, $db->error);
    }

    function db_open($host_addr, $user, $pswd, $db_name)
    {
        $db = new mysqli($host_addr, $user, $pswd, $db_name);
        if ($db->connect_error) {
            _err_cb($db, $db->connect_error);
        } else if (!$db->set_charset('utf8')) {
            _err_cb($db, $db->error);
        }
        return $db;
    }

    function db_close($db)
    {
        if (!$db->connect_error)
            $db->close();
        else
            _err_cb($db, $db->connect_error);
    }

    function db_escape_string($db, &$set)
    {
        foreach ($set as $k => $v) {
            if (is_string($v)) {
                if (is_object($set))
                    $set->$k = $db->real_escape_string($v);
                else
                    $set[$k] = $db->real_escape_string($v);
            }
        }
        return $set;
    }

    function sql_insert($tbl, $data)
    {
        $cols = '';
        $vals = '';
        foreach ($data as $k => $v) {
            $cols = $cols . $k . ",";
            $vals = $vals . ($v === null ? "NULL," : "'" . $v . "',");
        }
        $cols = rtrim($cols, ',');
        $vals = rtrim($vals, ',');

        $sql = sprintf("INSERT INTO %s (%s) VALUES (%s);",
            $tbl, $cols, $vals);
        return $sql;
    }

    function sql_update($tbl, $set, $cols, $ops, $vals, $cons)
    {
        $s = _dbutil_set($set);
        $w = _dbutil_where($cols, $ops, $vals, $cons);
        $sql = sprintf("UPDATE %s SET %s WHERE %s;",
            $tbl, $s, $w);
        return $sql;
    }

    function db_insert($db, $tbl, $data)
    {
        return _db_query($db, sql_insert($tbl, $data));
    }

    function db_select($db, $tbl, $sel = null, $cols = null, $ops = null, $vals = null, $cons = null, $order = null, $limit = null, $start = 0)
    {
        $w = _dbutil_where($cols, $ops, $vals, $cons);
        $s = $sel;
        if ($sel == null) {
            $s = '*';
        } else if (is_array($sel)) {
            $s = _dbutil_as($sel);
        }
        if ($order != null)
            $order = _dbutil_order($order);
        else
            $order = '';
        $sql = sprintf("SELECT %s FROM %s WHERE %s",
                $s, $tbl, $w) . $order;
        if ($limit !== null)
            $sql .= ' LIMIT ' . $start . ',' . $limit;

        return _db_query($db, $sql);
    }

    function db_update($db, $tbl, $set, $cols = null, $ops = null, $vals = null, $cons = null)
    {
        $sql = sql_update($tbl, $set, $cols, $ops, $vals, $cons);
        return _db_query($db, $sql);
    }

    function db_delete($db, $tbl, $cols, $ops, $vals, $cons = null)
    {
        $w = _dbutil_where($cols, $ops, $vals, $cons);
        $sql = sprintf("DELETE FROM %s WHERE %s",
            $tbl, $w);
        return _db_query($db, $sql);
    }

    function db_set_autoinc($db, $tbl, $ai = 0)
    {
        $sql = sprintf("ALTER TABLE %s AUTO_INCREMENT=%s", $tbl, $ai);

        return _db_query($db, $sql);
    }

    function db_free_results($db)
    {
        do {
            if ($result = $db->store_result()) {
                $result->free();
            }
        } while ($db->next_result());
    }

    function db_clear_tbls($db, $tbls)
    {
        $sql = '';
        foreach ($tbls as $tbl)
            $sql .= sprintf("DELETE FROM %s;", $tbl);
        _db_multi_query($db, $sql);
        //
        db_free_results($db);
    }

    function db_last_insert_id($db, $tbl)
    {
        $new_id_res = db_select($db, $tbl, 'last_insert_id() AS id');
        $id = $new_id_res->fetch_assoc()['id'];
        $new_id_res->free();
        return $id;
    }

    function db_next_insert_id($db, $db_name, $tbl)
    {
        $res = db_select($db, 'information_schema.TABLES', ['AUTO_INCREMENT' => 'id'], [
            'TABLE_SCHEMA' => $db_name,
            'TABLE_NAME' => $tbl
        ]);
        $id = $res->fetch_assoc()['id'];
        $res->free();
        return $id;
    }

    function convert_res_assoc_array($res)
    {
        $ret = [];
        while ($row = $res->fetch_assoc()) {
            $ret[] = $row;
        }
        return $ret;
    }

    function convert_obj_assoc($obj)
    {
        $ret = [];
        foreach ($obj as $k => $v)
            $ret[$k] = $v;
        return $ret;
    }

    function _dbutil_in($in)
    {
        $i = '';
        foreach ($in as $k => $v) {
            $i .= "'" . $v . "',";
        }
        $i = rtrim($i, ',');
        return '(' . $i . ')';
    }

    function _dbutil_where_deprecated($where, $con = 'AND')
    {
        $w = '1';
        if ($where) {
            $w = '';
            foreach ($where as $k => $v) {
                if (is_numeric($k))
                    $w .= ' ' . $v . ' ' . $con;
                else
                    $w .= ' ' . $k . "='" . $v . "' " . $con;
            }
            $w = rtrim($w, $con);
        }
        return $w;
    }

    function _dbutil_where($cols, $ops, $vals, $cons)
    {
        $w = '1';

        $num_cols = count($cols);

        if ($num_cols > 0) {
            $index = 0;
            $w = $cols[$index] . ' ' . $ops[$index] . " '" . $vals[$index] . "'";
            while (++$index < $num_cols) {
                $w .= ' ' . $cons[$index - 1] . ' ' . $cols[$index] . ' ' . $ops[$index] . " '" . $vals[$index] . "'";
            }
        }

        return $w;
    }

    function _dbutil_set($set)
    {
        $s = '';
        foreach ($set as $k => $v) {
            if ($v === null)
                continue;
            else if ($v == 'NULL')
                $s = $s . $k . "=" . $v . ",";
            else
                $s = $s . $k . "='" . $v . "',";
        }
        $s = rtrim($s, ',');
        return $s;
    }

    function _dbutil_as($as)
    {
        $a = '';
        foreach ($as as $k => $v) {
            $a = $a . $k . ' as `' . $v . '`,';
        }
        $a = rtrim($a, ',');
        return $a;
    }

    function _dbutil_order($order)
    {
        // ('key1'=>true/false, 'key2'=>true/false)
        $o = ' ORDER BY ';
        foreach ($order as $k => $v) {
            $o .= $k . ' ' . ($v == true ? 'ASC' : 'DESC') . ',';
        }
        $o = rtrim($o, ',');
        return $o;
    }
}
