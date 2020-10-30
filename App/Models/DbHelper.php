<?php
/* Shaoran DbHelper framework 3.1 */
class DbHelper {
  private static $conn;
  private $iconv = ['Enable' => false, 'InChar' => 'UTF-8', 'OutChar' => 'UTF-8'];
  private $method = 0;
  private $entity = null;
  private $attr = null;
  private $where = null;
  private $orderBy = null;
  private $groupBy = null;
  private $limit = null;
  private $cmd = null;
  private $params = [];

  public function Connect($set = null) {
    if ($set == null || !is_array($set)) {
      echo 'no dsn connection';
      exit;
    }
    try {
      self::$conn = new PDO($set['Dsn'], $set['Username'], $set['Password'], [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]);
    }
    catch (PdoException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  public function GetStatus() {
    return isset(self::$conn);
  }

  public function SetIconv($enable = false, $inChar = null, $outChar = null) {
    $this->iconv['Enable'] = $enable;
    if ($inChar != null) $this->iconv['InChar'] = $inChar;
    if ($outChar != null) $this->iconv['OutChar'] = $outChar;
  }

  public function Select($entity = null, $attr = null) {
    $this->method = 0;
    $this->Reset();
    if ($entity != null) {
      $this->entity = $entity;
      $this->attr = $attr != null ? is_array($attr) ? join(',', $attr) : $attr : '*';
    }
  }

  public function Update($entity = null, $attr = null) {
    $this->method = 1;
    $this->Reset();
    if ($entity != null) {
      $this->entity = $entity;
      if ($attr != null && is_array($attr)) {
        $i = 0;
        foreach ($attr as $k => $v) {
          if (isset($v)) {
            if ($i < count($attr) && $i > 0) $attrs .= ', ';
            $this->attr .= "{$k}=?";
            $this->params[] = $v;
            $i++;
          }
        }
      }
    }
  }

  public function Insert($entity = null, $attr = null) {
    $this->method = 2;
    $this->Reset();
    if ($entity != null) {
      $this->entity = $entity;
      $attrs = [];
      $values = [];
      if ($attr != null && is_array($attr)) {
        foreach ($attr as $k => $v) {
          if (isset($v)) {
            $attrs[] = $k;
            $values[] = '?';
            $this->params[] = $v;
          }
        }
      }
      $this->attr = '('.join(',', $attrs).') VALUES('.join(',', $values).')';
    }
  }

  public function Delete($entity = null) {
    $this->method = 3;
    $this->Reset();
    if ($entity != null)
      $this->entity = $entity;
  }

  public function Where($attr = null) {
    $cmd = null;
    $paramNotNull = $this->ParamNotNull($attr);
    if ($attr != null && is_array($attr)) {
      $i = 0;
      foreach ($attr as $k => $v) {
        if (is_array($v)) {
          if (count($v) > 0) {
            foreach ($v as $subK => $subV) {
              if (isset($subV)) {
                switch (strtoupper($subK)) {
                  case 'LIKE':
                    if ($i < 1) $cmd .= '(';
                    if ($i > 0) $cmd .= ' OR ';
                    $cmd .= "{$k} LIKE ?";
                    if ($i == $paramNotNull['LIKE'] - 1)
                      $cmd .= ')';
                    break;
                  case 'ISNOT':
                    if ($i > 0) $cmd .= ' AND ';
                    $cmd .= "{$k}!=?";
                    break;
                  case 'IN':
                  case 'NOTIN':
                    if ($i > 0) $cmd .= ' AND ';
                    $cmd .= "{$k} ".strtoupper($subK)."(";
                    if (is_array($subV)) {
                      $j = 0;
                      foreach ($subV as $subVal) {
                        if ($j < count($subV) && $j > 0) $cmd .= ',';
                        $cmd .= '?';
                        $j++;
                      }
                    }
                    else $cmd .= '?';
                    $cmd .= ')';
                    break;
                  case 'MORE':
                    if ($i > 0) $cmd .= ' AND ';
                    $cmd .= "{$k}>?";
                    break;
                  case 'LESS':
                    if ($i > 0) $cmd .= ' AND ';
                    $cmd .= "{$k}<?";
                    break;
                  case 'IS':
                  default:
                    if ($i > 0) $cmd .= ' AND ';
                    $cmd .= "{$k}=?";
                    break;
                }
                if (is_array($subV) && count($subV) > 0) {
                  foreach ($subV as $getSubV) {
                    $this->params[] = $getSubV;
                  }
                }
                else $this->params[] = $subV;
                $i++;
              }
            }
          }
        }
        else {
          if (isset($v)) {
            if ($i > 0) $cmd .= ' AND ';
            $cmd .= "{$k}=?";
            $this->params[] = $v;
            $i++;
          }
        }
      }
    }
    else if ($attr != null) $cmd = $attr;
    if ($cmd != null)
      $this->where = $this->where != null ? " {$this->where} AND {$cmd}" : " WHERE {$cmd}";
  }

  public function AppendWhere($sql = null) {
    $this->where .= $this->where != null ? ' AND ' : ' WHERE ';
    if (isset($sql)) $this->where .= $sql;
  }

  public function OrderBy($attr) {
    if ($attr != null && is_array($attr)) {
      $this->orderBy .= ' ORDER BY ';
      $i = 0;
      foreach ($attr as $k => $v) {
        if ($i < count($attr) && $i > 0) $this->orderBy .= ',';
        $this->orderBy .= $k;
        switch (strtoupper($v)) {
          default:
          case '09':
          case 'AZ':
          case 'ASC':
          case '<':
            $this->orderBy .= ' ASC';
            break;
          case '90':
          case 'ZA':
          case 'DESC':
          case '>':
            $this->orderBy .= ' DESC';
            break;
        }
        $i++;
      }
    }
  }

  public function GroupBy($attr) {
    if ($attr != null && is_array($attr)) {
      $this->groupBy .= ' GROUP BY ';
      $i = 0;
      foreach ($attr as $k) {
        if ($i < count($attr) && $i > 0) $this->groupBy .= ',';
        $this->groupBy .= $k;
        $i++;
      }
    }
  }

  public function Limit($limit, $offset = 25) {
    if (isset($limit) && is_numeric($limit)) {
      $this->limit = " LIMIT {$limit}";
      if (isset($offset) && is_numeric($offset)) $this->limit .= ", {$offset}";
    }
  }

  public function GetCommand() {
    $this->CreateCmd();
    return $this->cmd;
  }

  public function GetParameter() {
    return $this->params;
  }

  public function Execute() {
    $this->CreateCmd();
    switch ($this->method) {
      case 0:
        $result = [];
        if ($this->cmd != null) {
          $query = $this->ExecuteCmd();
          if ($query != null && $query->rowCount() > 0) {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
              $result[] = $this->CharConvert($row, true);
            }
          }
        }
        return $result;
        break;
      default:
        $result = false;
        if ($this->cmd != null) {
          $query = $this->ExecuteCmd();
          if ($query != null) $result = $query->rowCount() > 0;
        }
        return $result;
        break;
    }
  }

  private function ParamNotNull($attr = null) {
    $result = ['LIKE' => 0, 'ISNOT' => 0, 'IN' => 0, 'NOTIN' => 0, 'MORE' => 0, 'LESS' => 0, 'IS' => 0];
    if ($attr != null && is_array($attr)) {
      foreach ($attr as $k => $v) {
        if (is_array($v)) {
          if (count($v) > 0) {
            foreach ($v as $subK => $subV) {
              if (isset($subV)) $result[strtoupper($subK)]++;
            }
          }
        }
        else
          if (isset($v)) $result['IS']++;
      }
    }
    return $result;
  }

  private function CreateCmd() {
    switch ($this->method) {
      case 0:
        $this->cmd = "SELECT {$this->attr} FROM {$this->entity}";
        if ($this->where != null) $this->cmd .= $this->where;
        if ($this->orderBy != null) $this->cmd .= $this->orderBy;
        if ($this->groupBy != null) $this->cmd .= $this->groupBy;
        if ($this->limit != null) $this->cmd .= $this->limit;
        break;
      case 1:
        $this->cmd = "UPDATE {$this->entity} SET {$this->attr}";
        if ($this->where != null) $this->cmd .= $this->where;
        break;
      case 2:
        $this->cmd = "INSERT INTO {$this->entity} {$this->attr}";
        break;
      case 3:
        $this->cmd = "DELETE FROM {$this->entity}";
        if ($this->where != null) $this->cmd .= $this->where;
        break;
    }
  }

  private function Reset() {
    $this->entity = null;
    $this->attr = null;
    $this->where = null;
    $this->orderBy = null;
    $this->groupBy = null;
    $this->limit = null;
    $this->cmd = null;
    $this->params = [];
  }

  private function ExecuteCmd() {
    $query = null;
    $params = $this->method < 1 ? $this->CharConvert($this->params) : $this->params;
    try {
      $query = self::$conn->prepare($this->cmd);
      $query->execute($params);
    }
    catch (exception $e) {
      echo $e->getMessage();
      exit;
    }
    return $query;
  }

  private function CharConvert($data = [], $revert = false) {
    if ($data != null && is_array($data)) {
      if (!$this->iconv['Enable']) {
        $inChar = $revert ? $this->iconv['OutChar'] : $this->iconv['InChar'];
        $outChar = $revert ? $this->iconv['InChar'] : $this->iconv['OutChar'];
        return array_combine(array_keys($data), array_map(function ($v) use ($inChar, $outChar) {
          return iconv($inChar, $outChar, $v);
        }, $data));
      }
    }
    return $data;
  }
}
?>
